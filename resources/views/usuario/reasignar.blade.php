@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

@if(session('info'))
<div class="alert alert-success">
    <strong>{{session('info')}} </strong>
</div>
@endif

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REASIGNAR LINEA</title>
</head>

<body>
    <div class="text-center">
        <h1>REASIGNAR LINEA</h1>
    </div>
    <div class="row justify-content-center mx-5">

        <h2> Datos Actuales</h2>
        <div class="form-group col-md-7 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nombre</h5>
                    <p class="form-control">{{$usuarios->nombres}} {{$usuarios->apellidos}}</p>
                    <h5 class="card-title">Cuenta</h5>
                    <p class="form-control"> 
                        @foreach ($cuentas as $cuenta)
                        @if ($cuenta->id==$usuarios->cuenta)
                        {{$cuenta->nombreCuenta}}
                        @endif
                        @endforeach
                    </p>
                    <h5 class="card-title">Actividad</h5>
                    <p class="form-control"> 
                        @foreach ($actividades as $actividad)
                        @if ($actividad->id==$usuarios->actividad)
                        {{$actividad->nombreCargo}}
                        @endif
                        @endforeach
                    </p>
                </div>
            </div>
        </div>

        <h2> Reasignar linea</h2>
        <form action="{{url('/usuarios/guardarResignar')}}" method="post" class="form-group col-md-7 mb-3">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
           <input type="hidden" name=usuario value="{{$usuarios->id}}">


            <div class="form-group col-md-7 mb-3">
                <label for="linea" class="form-label">Linea</label>
                <select class="form-select" aria-label="Default select example" name="linea" id="linea">
                    <option selected>seleccione una linea</option>
                    @foreach ($lineas as $linea)
                    <option value="{{$linea->id}}">{{$linea->numeroLinea}}  </option>
                    @endforeach
                </select>
            </div>
            <!--  <div class="form-group col-md-7 mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" name="nombres" id="nombres">
            </div>

            <div class="form-group col-md-7 mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" name="apellidos" id="apellidos">
            </div>

            <div class="form-group col-md-7 mb-3">
                <label for="cuenta" class="form-label">Cuenta</label>
                <select class="form-select" aria-label="Default select example" name="cuenta" id="cuenta">
                    <option selected>seleccione</option>
                    @foreach ($cuentas as $cuenta)
                    <option value="{{$cuenta->nombreCuenta}}">{{$cuenta->nombreCuenta}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-7 mb-3">
                <label for="actividad" class="form-label">Actividad</label>
                <select class="form-select" aria-label="Default select example" name="actividad">
                    <option selected>seleccione</option>
                    @foreach ($actividades as $actividad)
                    <option value="{{$actividad->nombreCargo}}">{{$actividad->nombreCargo}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-7 mb-3">
                <label for="responsable" class="form-label">Responsable</label>
                <input type="text" class="form-control" name="responsable" id="responsable">
            </div>
-->

            <input type="submit" value="Reasignar Usuario">

        </form>
    </div>


</body>

</html>
@endsection