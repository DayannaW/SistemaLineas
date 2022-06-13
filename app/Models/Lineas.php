<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lineas extends Model
{
    
    static $rules = [
		'numeroLinea' => 'required',
		'operadora' => 'required',
		'planilla' => 'required',
		'plan' => 'required',
		'valor' => 'required',
		'usuario' => 'required',
        'cuenta' => 'required',
        'actividad' => 'required',
		'responsable' => 'required',
        'presupuesto'=> 'required',
        'estado'=> 'required',
        'fecha_requerimiento'=>'required'
    ];

    protected $perPage = 20;

    protected $fillable = [
        'numeroLinea',
        'operadora',
        'empresaInterna_id',
        'planilla',
        'plan',
        'observacion',
        'valor',
        'nombres_usuario',
        'apellidos_usuario',
        'cuenta',
        'actividad',
        'responsable',
        'presupuesto',
        'estado',
        'fecha_requerimiento'
    ];


    //relacion uno a muchos (inversa)

    public function empresa(){
        return $this->belongsTo('App\Models\Empresa');
    }

    public function usuario(){
        return $this->belongsTo('App\Models\Usuarios');
    }

    //relacion uno a muchos

    public function reposiciones(){
        return $this->hasMany('App\Models\reposicion');
    }

    public function reasignaciones(){
        return $this->hasMany('App\Models\reasignacion');
    }

}
