<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Redirect;

use App\Rol;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Rol::where('estado',1)->orderBy('id')->get();      
        return View('administracion.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administracion.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        Rol::create([
            'rol' =>  $request->rol,
            'descripcion' =>  $request->descripcion,
            'fecha_registro' =>  $request->fecha_registro,
      
        
        ]);

        return Redirect::to('administracion/roles')->with('mensaje-registro', 'Se registró Correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol = Rol::find($id);
       
        return view('administracion.roles.edit',compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rol = Rol::find($id);

        $rol->fill([

            'rol' =>  $request->rol,
            'descripcion' => $request->descripcion,
            'fecha_registro' => $request->fecha_registro,

       ]);

           
       if($rol->save()){
        return Redirect::to('administracion/roles')->with('mensaje-registro', 'Registro Actualizado Correctamente');
       }else{
        return Redirect::to('administracion/roles')->with('mensaje-error', 'Ocurrio un error');

       }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $rol = Rol::find($id);
        $rol->estado = 0;
        $rol->save();

        DB::table('user_rol')->where('rol_id', $rol->id)->delete();
        $message = "Eliminado Correctamente";
        if ($request->ajax()) {
            return response()->json([
               
                'message' => $message
            ]);
        }
    }

    public function roles_ajax(Request $request)
    { 

            $roles = Rol::where('estado',1)->get();

            //$roles = DB::select("select * from rol where estado= 1");

            //
            return Datatables::of($roles)
                    ->addIndexColumn()
                    ->setRowId('id')
              
                    ->addColumn('accion', function($row){

                        $url = route('roles.edit',['parameters' => $row->id]);
   
                           $btn = '<a title="Editar" style="cursor:pointer;" href="'.$url. '" role="button"><i class="fa fa-edit"></i></a> <a title="Eliminar" style="cursor:pointer;"   onclick="eliminar_rol('.$row->id.')" class="btn-delete" role="button"><i class="fa fa-trash"></i></a>';
     
                            return $btn;
                    })
                    ->rawColumns(['accion'])
                    ->make(true);
        
      
      
    }


}
