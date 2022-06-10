@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lineas</title>
</head>

<body>
    <div class="text-center">
        <h1>LISTADO DE LINEAS ACTIVAS</h1>
    </div>

    <div class="row justify-content-center mb-3 mx-5">

        <div class="container-md ">
            <div class="btn-toolbar justify-content-between " role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mb-3" role="group" aria-label="First group">
                    <button type="button" class="btn btn-outline-secondary">Copiar</button>
                    <a class="btn btn-outline-secondary" href="{{route('lineas.exportarExcel')}}">Excel</a>
                    <a class="btn btn-outline-secondary" href="{{route('lineas.exportarCsv')}}">CSV</a>
                </div>

                <form action="{{route('lineas.buscar')}}" method="get" class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Escriba un nombre" name="texto">
                    <input class="btn btn-primary" type="submit" id="button-addon2" value="Buscar">
                </form>
       
                <div class="btn-group mb-3">
                    <a type="button" class="btn btn-primary" aria-label="Input group example" href="{{url('/lineas/create')}}">Crear</a>
                </div>
      
            </div>
        </div>
        <div class="container-md">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Numero</th>
                        <th scope="col">Operadora</th>
                        <th scope="col">Empresa</th>
                        <th scope="col">Planilla</th>
                        <th scope="col">Plan</th>
                        <th scope="col">Observacion</th>
                        <th scope="col">Tarifa</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Cuenta</th>
                        <th scope="col">Actividad</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Presupuesto</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($lineas)<=0) <tr>
                        <td colspan="8">No existen registros</td>
                        </tr>
                        @else
                        @foreach ($lineas as $linea)
                        <tr>
                            <td>{{$linea->numeroLinea}}</td>
                            <td>{{$linea->operadora}}</td>
                            <td>@foreach ($empresa as $empresas)
                                @if ($empresas->id==$linea->empresaInterna_id)
                                {{$empresas->nombreEmpresa}}
                                @endif
                                @endforeach
                            </td>
                            <td>{{$linea->planilla}}</td>
                            <td>{{$linea->plan}}</td>
                            <td>{{$linea->observacion}} </td>
                            <td>{{$linea->valor}}</td>
                            <td>{{$linea->nombres_usuario}} {{$linea->apellidos_usuario}}</td>
                            <td>@foreach ($cuentas as $cuenta)
                                @if ($cuenta->id==$linea->cuenta)
                                {{$cuenta->nombreCuenta}}
                                @endif
                                @endforeach
                            </td>
                            <td>@foreach ($actividades as $actividad)
                                @if ($actividad->id==$linea->actividad)
                                {{$actividad->nombreCargo}}
                                @endif
                                @endforeach
                            </td>
                            <td>{{$linea->responsable}}</td>
                            <td>{{$linea->presupuesto}} </td>
                            <td class="menu_opciones">

                                <div type="button" class="options_menu">
                                    <button class="menu_link  btn btn-primary">Opciones</button>
                                    <ul class="menu_container">
                                        <li class="opcion_desplegable">
                                            <a href="{{ route('lineas.edit', $linea->id) }}" class="menu_link menu_link--inside">Modificar</a>
                                        </li>
                                        <li class="opcion_desplegable">
                                            <a href="{{ route('lineas.reasignar',$linea->id) }}" class="menu_link menu_link--inside">Reasignar</a>
                                        </li>
                                        <li class="opcion_desplegable">
                                            <a href="#" class="menu_link menu_link--inside">Reposicion</a>
                                        </li>
                                        <li class="opcion_desplegable">
                                            <a href="#" class="menu_link menu_link--inside">Inhabilitar</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif

                </tbody>
            </table>
           
        </div>
        {!!$lineas->links()!!}
    </div>



   
</body>

</html>
@endsection