@extends('layouts.app')

@section('content')

<div class="container">
    @if (Session::has('Mensaje'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('Mensaje') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    @endif

    <div class="d-inline">
        <h2>Empleados
            <a href="{{ url('empleados/create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Agregar Empleado
            </a>
        </h2>
    </div>

    <table class="table table-dark table-hover pt-1 shadow">
        <thead class="thead-dark ">
            <tr>
                <th>N°</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        @foreach ($empleados as $empleado)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>
                <img src="{{ asset('storage').'/'.$empleado->Foto }}" class="img-thumbnail img-fluid" alt="" width="100">
                </td>
                <td>{{ $empleado->Nombre }} {{ $empleado->ApellidoPaterno }} {{ $empleado->ApellidoMaterno }}</td>
                <td>{{ $empleado->Correo }}</td>
                <td>

                    <a class="btn btn-success" href="{{ url('/empleados/'.$empleado->id.'/edit') }}">
                        <i class="far fa-edit"></i> Editar
                    </a>



                <form action="{{ url('/empleados/'.$empleado->id) }}" method="post" class="d-inline">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Borrar?');">
                        <i class="far fa-trash-alt"></i> Borrar
                    </button>
                </form>


                </td>
            </tr>
        @endforeach
        </tbody>

    </table>


    <hr>
    <div class="d-flex justify-content-center">
        {{ $empleados->links() }}
    </div>


</div>

@endsection
