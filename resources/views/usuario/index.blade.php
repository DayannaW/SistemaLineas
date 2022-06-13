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
        <h1>LISTADO DE USUARIOS</h1>
    </div>

    <div class="row justify-content-center mb-3 mx-5">

        <div class="container-md ">
            <div class="btn-toolbar justify-content-between " role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mb-3" role="group" aria-label="First group">
                    <button type="button" class="btn btn-outline-secondary">Copiar</button>
                    <button type="button" class="btn btn-outline-secondary">Excel</button>
                    <button type="button" class="btn btn-outline-secondary">CSV</button>
                </div>

                <form action="{{route('usuarios.buscar')}}" method="get" class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Escriba un nombre" name="texto">
                    <input class="btn btn-primary" type="submit" id="button-addon2" value="Buscar">
                </form>

                <div class="btn-group mb-3">
                    <a type="button" class="btn btn-primary" aria-label="Input group example" href="{{url('/usuarios/create')}}">Crear</a>
                </div>
            </div>
        </div>
        <div class="container-md">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Cedula</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Cuenta</th>
                        <th scope="col">Actividad</th>
                        <th scope="col">Linea Asignada</th>
                        <th scope="col">Responsable?</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)

                    <tr>
                        <td>{{$usuario->cedula}}</td>
                        <td>{{$usuario->nombres}}</td>
                        <td>{{$usuario->apellidos}}</td>
                        <td>@foreach ($cuentas as $cuenta)
                            @if ($cuenta->id==$usuario->cuenta)
                            {{$cuenta->nombreCuenta}}
                            @endif
                            @endforeach</td>
                        <td>@foreach ($actividades as $actividad)
                            @if ($actividad->id==$usuario->actividad)
                            {{$actividad->nombreCargo}}
                            @endif
                            @endforeach </td>
                        <td>@foreach ($lineas as $linea)
                            @if ($linea->id==$usuario->numeroLinea)
                            {{$linea->numeroLinea}}
                            @endif
                            @endforeach
                        </td>
                        <td>{{$usuario->responsable}}</td>
                        
                        <td class="menu_opciones">

                            <div type="button" class="options_menu">
                                <button class="menu_link  btn btn-primary">Opciones</button>
                                <ul class="menu_container">
                                    <li class="opcion_desplegable">
                                        <a href="{{ route('lineas.edit', $linea->id) }}" class="menu_link menu_link--inside">Modificar</a>
                                    </li>
                                    <li class="opcion_desplegable">
                                        <a href="{{ route('usuarios.reasignar',$usuario->id) }}" class="menu_link menu_link--inside">Reasignar</a>
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

                  
                </tbody>
            </table>
        </div>
        {!!$usuarios->links()!!}
    </div>

   

    <script src="js/app.js"> </script>
</body>

</html>
@endsection