<?php

namespace App\Http\Controllers;

use App\Exports\LineasExport;
use App\Models\Lineas;
use App\Models\Empresa;
use App\Models\Usuarios;
use App\Models\Cuentas;
use App\Models\User;
use App\Models\Actividades;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class LineasController extends Controller
{

    public function index()
    {
        //dd(Auth::user()->name);                          ARREGLAR LAS LINEAS QUE VE EL ADMINISTRADOR
        
        $lineas=Lineas::where('estado', '!=', 7)->paginate(20);
        $usuarios = Usuarios::all();
        $empresa = Empresa::all();
        $cuentas = Cuentas::all();
        $actividades = Actividades::all();

        return view('Linea.index', compact('lineas', 'usuarios', 'empresa', 'cuentas', 'actividades'));
    }


    public function create()
    {
        $lineas = new Lineas();
        $empresas = Empresa::all();
        return view('Linea.crear', compact('lineas', 'empresas'));
    }


    public function store(Request $request)
    {
        $lineas = Lineas::all();
        $empresa = Empresa::all();
        $cuentas = Cuentas::all();
        $actividades = Actividades::all();
        $cantidad = $request->numeros;
        //dd($cantidad);
        for ($i = 0; $i < count($cantidad); $i++) {
            $registrar =  Lineas::create([
                'numeroLinea' => $request->numeros[$i],
                'operadora' => $request->operadora,
                'empresaInterna_id' => $request['empresaInterna_id'],
                'planilla' => $request['planilla'],
                'plan' => $request['plan'],
                'observacion' => $request['observacion'],
                'valor' => $request['valor'],
                'nombres_usuario' => $request['nombres_usuario'],
                'apellidos_usuario' => $request['apellidos_usuario'],
                'presupuesto' => $request['presupuesto'],
                'estado' => 0
            ]);
        }

        return redirect()->route('lineas.index');
    }


    public function edit($id)
    {
        $linea = Lineas::find($id);
        $empresas = Empresa::all();
        return view('Linea.editar', compact('linea', 'empresas'));
    }


    public function update(Request $request)
    {
        $linea = Lineas::find($request->id);
        $linea->update($request->all());
        $usuario = Usuarios::where('numeroLinea', '=', $request->id_linea)->update([
            'nombres' => $request['nombres_usuario'],
            'apellidos' => $request['apellidos_usuario'],
            'numeroLinea' => $request['id_linea'],
            'responsable' => $request['responsable'],
        ]);
        return redirect()->route('lineas.index');
    }


    public function reasignar($id)
    {
        $linea = Lineas::find($id);
        $cuentas = Cuentas::all();
        $actividades = Actividades::all();
        $usuarios = Usuarios::all();
        return view('Linea.reasignar', compact('linea', 'cuentas', 'actividades', 'usuarios'));
    }


    public function guardarReasignar(Request $request)
    {
        $linea   = Lineas::where('estado', '=', 0,)                                       //actualizando estado de la linea, de  0 a 7 
            ->where('id', '=', $request->numeroLinea)
            ->update(['estado' => 7]);

        $usuarioA = Usuarios::where('numeroLinea', $request->numeroLinea)->get();         //desvincular la linea del usuario anterior si lo tiene
        if (count($usuarioA) != 0){
            $usA = $usuarioA[0];
            $usA->update(['numeroLinea' => NULL]);
        }
        $usuario = Usuarios::where('cedula', $request->usuario)->get();                   //comprobando si existen dos lineas con el mismo usuario  
        if (count($usuario) < 2) {
            $lineaB   = Lineas::find($request->numeroLinea);
            $us = $usuario[0];
            $nuevaLinea = Lineas::create([
                'numeroLinea' => $lineaB['numeroLinea'],
                'operadora' => $lineaB['operadora'],
                'empresaInterna_id' => $lineaB['empresaInterna_id'],
                'planilla' => $lineaB['planilla'],
                'plan' => $lineaB['plan'],
                'observacion' => $lineaB['observacion'],
                'valor' => $lineaB['valor'],
                'nombres_usuario' => $us['nombres'],
                'apellidos_usuario' => $us['apellidos'],
                'cuenta' => $us['cuenta'],
                'actividad' => $us['actividad'],
                'responsable' => $us['responsable'],
                'presupuesto' => $lineaB['presupuesto'],
                'estado' => 0
            ]);
            if ($us->numeroLinea != NULL) {                                             //si el unico usuario existente ya tiene linea asignada
                Usuarios::create([                                                      //crea un nuevo registro de usuario con otra linea
                    'cedula' => $us['cedula'],
                    'nombres' => $us['nombres'],
                    'apellidos' => $us['apellidos'],
                    'cuenta' => $us['cuenta'],
                    'actividad' => $us['actividad'],
                    'numeroLinea' => $nuevaLinea['id'],
                    'responsable' => $us['responsable']
                ]);
            } else {                                                                    //asigna la linea al campo vacio             
                $us_up = Usuarios::where('cedula', $request->usuario)
                                ->update(['numeroLinea' => $nuevaLinea['id']]);
            }
        } else {
            $usuario_u = Usuarios::where('cedula', '=', $request->usuario)->take(1)->get();
            $us_ar = $usuario_u[0];
            $lineaC   = Lineas::where('estado', '=', 0,)
                ->where('id', '=', $request->numeroLinea)
                ->get();
            Lineas::create([
                'numeroLinea' => $lineaC['numeroLinea'],
                'operadora' => $lineaC['operadora'],
                'empresaInterna_id' => $lineaC['empresaInterna_id'],
                'planilla' => $lineaC['planilla'],
                'plan' => $lineaC['plan'],
                'observacion' => $lineaC['observacion'],
                'valor' => $lineaC['valor'],
                'nombres_usuario' => $us_ar['nombres'],
                'apellidos_usuario' => $us_ar['apellidos'],
                'cuenta' => $us_ar['cuenta'],
                'actividad' => $us_ar['actividad'],
                'responsable' => $us_ar['responsable'],
                'presupuesto' => $lineaC['presupuesto'],
                'estado' => 0
            ]);

            Usuarios::create([
                'cedula' => $us_ar['cedula'],
                'nombres' => $us_ar['nombres'],
                'apellidos' => $us_ar['apellidos'],
                'cuenta' => $us_ar['cuenta'],
                'actividad' => $us_ar['actividad'],
                'numeroLinea' => $request['numeroLinea'],
                'responsable' => $us_ar['responsable']
            ]);
        }
        return redirect()->route('lineas.index')->with('info', 'linea asignada exitosamente');
    }

    public function exportarExcel()
    {
        return Excel::download(new LineasExport, 'ListadoLineas.xlsx');
    }

    public function exportarCsv()
    {
        return Excel::download(new LineasExport, 'ListadoLineas.csv');
    }

    public function buscar(Request $request)
    {
        define('texto',$request['texto'])  ;
        $empresa = Empresa::select('id','nombreEmpresa')->get();
        $cuentas = Cuentas::select('id','nombreCuenta')->get();
        $actividades = Actividades::select('id','nombreCargo')->get();
        $lineas = Lineas::join('empresas','empresas.id','=','lineas.empresaInterna_id')
        ->join('cuentas','cuentas.id','=','lineas.cuenta')
       // dd($lineas);
         ->where([['estado', '!=', 7]])
         ->where(function($query){
            $query->orwhere('nombres_usuario','LIKE','%'.texto.'%')
            ->orwhere('apellidos_usuario','LIKE','%'.texto.'%')
            ->orwhere('numeroLinea','LIKE','%'.texto.'%')
            ->orwhere('operadora','LIKE','%'.texto.'%')
            ->orwhere('nombreEmpresa','LIKE','%'.texto.'%')
            ->orwhere('nombreCuenta','LIKE','%'.texto.'%')
            ->orwhere('responsable','LIKE','%'.texto.'%');
        })->paginate(20);

        return view('linea.index',compact('lineas', 'empresa', 'cuentas', 'actividades'));
    }


    public function destroy(Linea $linea)
    {
        //
    }
}



/*



*/
