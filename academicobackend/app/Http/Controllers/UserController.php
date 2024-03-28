<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $inputs["password"] = Hash::make(trim($request->password));
        $e = User::create($inputs);
        return response()->json([
            'data'=>$e,
            'mensaje'=>"Usuario ingresado con exito"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $e = User::find($id);
        if(isset($e)){
            return response()->json([
                'data'=>$e,
                'mensaje'=>"Usuario encontrado con exito"
            ]);
        } else {
            return response()->json([
                'error'=>true,
                'mensaje'=>"No existe el usuario"
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $e = User::find($id);
        if (isset($e)){
            $e->firstname = $request->firstname;
            $e->last_name = $request->last_name;
            $e->email = $request->email;
            $e->password = Hash::make($request->password);
            if($e->save()){
                return response()->json([
                    'data'=>$e,
                    'mensaje'=>"Usuario actualizado con exito"
                ]);
            } else {
                return response()->json([
                    'data'=>$e,
                    'mensaje'=>"No se pudo actualizar el usuario"
                ]);
            }
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>"No existe el usuario"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $e = User::find($id);
        if(isset($e)){
            $res=User::destroy($id);
            if($res){
            return response()->json([
                'data'=>$e,
                'mensaje'=>"Usuario eliminado con exito"
            ]);
            } else{
                return response()->json([
                    'data'=>$e,
                    'mensaje'=>"No se pudo eliminar el usuario"
                ]);
            }
        }else {
            return response()->json([
                'error'=>true,
                'mensaje'=>"No existe el usuario"
            ]);
        }
    }
}
