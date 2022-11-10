@extends('layouts.app')

@section('content')

{{--  Container para centrar el contenido  --}}
<div class="container">

{{--  Alerta de validaciones  --}}
@if (count($errors)>0)
<div class="alert alert-danger" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>
@endif



Seccion para crear empleados
<form action="{{ url('/empleados') }}" class="form-horizontal" method="post" enctype="multipart/form-data">

{{ csrf_field() }}
@include('empleados.empleadosForm',['Modo'=>'crear'])

</form>
</div>

@endsection
