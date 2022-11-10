<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['empleados']=Empleados::paginate(5);



        return view('empleados.empleadosIndex',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleados.empleadosCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // Validacion sencilla mediante laravel
        $campos=[
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email',
            'Foto' => 'required|max:10000|mimes:jpeg,png,jpg'
        ];
        // Mensaje de alerta formulario
        // si en el formulaio encuentra un required que no se ha insertado
        // un elemento valido, insertara el atributo del required con el texto derecho
        $Mensaje=["required"=>'El :attribute es requerido'];

        // Con este metodo validamos toda la informacion anterior ↑
        $this->validate($request,$campos,$Mensaje);



        $datosEmpleado=request()->except('_token');

        if($request->hasFile('Foto')){

            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');

        }

        Empleados::insert($datosEmpleado);

        return redirect('empleados')->with('Mensaje','Empleado agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function show(Empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $empleado= Empleados::findOrFail($id);

        return view('empleados.empleadosEdit',compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        // Validacion sencilla mediante laravel
        $campos=[
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email'
        ];

        if($request->hasFile('Foto')){

            $campos+=['Foto' => 'required|max:10000|mimes:jpeg,png,jpg'];

        }

        // Mensaje de alerta formulario
        // si en el formulaio encuentra un required que no se ha insertado
        // un elemento valido, insertara el atributo del required con el texto derecho
        $Mensaje=["required"=>'El :attribute es requerido'];

        // Con este metodo validamos toda la informacion anterior ↑
        $this->validate($request,$campos,$Mensaje);


        $datosEmpleado=request()->except(['_token','_method']);

        if($request->hasFile('Foto')){

            $empleado= Empleados::findOrFail($id);

            Storage::delete('public/'.$empleado->Foto);

            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');

        }

        Empleados::where('id','=',$id)->update($datosEmpleado);


        // $empleado= Empleados::findOrFail($id);
        // return view('empleados.empleadosEdit',compact('empleado'));

        return redirect('empleados')->with('Mensaje','Empleado modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $empleado= Empleados::findOrFail($id);

        if(Storage::delete('public/'.$empleado->Foto)){
            Empleados::destroy($id);

        }

        return redirect('empleados')->with('Mensaje','Empleado Eliminado');

    }
}
