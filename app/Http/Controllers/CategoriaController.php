<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Categoria;
use Validator;
use DB;
use Auth;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = DB::table('categorias as c')
                        ->leftJoin('users as u1', 'u1.id', '=', 'c.created_by')
                        ->leftJoin('users as u2', 'u2.id', '=', 'c.updated_by')
                        ->select('c.id', 'c.categoria', 'c.created_at', 'c.updated_at', 'u1.email as created_by', 'u2.email as updated_by')
                        ->whereNull('c.deleted_at')
                        ->get();

        return response()->json(['categorias' => $categorias], 200);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoria' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>array(['code'=>422, 'message'=>'Unprocessable Entity'])], 422);
        }
  
        $newCategoria = new Categoria();
        $newCategoria->categoria = $request->categoria;        
        $newCategoria->created_by = Auth::guard('api')->user()->id;
        $newCategoria->updated_by = Auth::guard('api')->user()->id;
        $newCategoria->save();

        return response()->json(['categoria' => $newCategoria], 201);            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = DB::table('categorias as c')
                       ->leftJoin('users as u1', 'u1.id', '=', 'c.created_by')
                       ->leftJoin('users as u2', 'u2.id', '=', 'c.updated_by')
                       ->select('c.id', 'c.categoria', 'c.created_at', 'c.updated_at', 'u1.email as created_by', 'u2.email as updated_by')
                       ->where('c.id', $id)
                       ->whereNull('c.deleted_at')
                       ->take(1)
                       ->get();

        if ($categoria != null)
        {
            return response()->json(['categoria' => $categoria], 200);
        }
        else
        {
            return response()->json(['errors'=>array(['code'=>404, 'message'=>'Resource Not Found'])], 404);
        }        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->all(), [
            'categoria' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>array(['code'=>422, 'message'=>'Unprocessable Entity'])], 422);
        }

        $oldCategoria = Categoria::where('id', $id)->first();

        if (!$oldCategoria)
        {            
            return response()->json(['errors' => array(['code' => 404, 'message' => 'Resource Not Found'])], 404);
        }

        $oldCategoria->categoria = $request->categoria;    
        $oldCategoria->updated_by = Auth::guard('api')->user()->id;
        $oldCategoria->save(); 

        return response()->json(['categoria' => $oldCategoria], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldCategoria = Categoria::where('id', $id)->first();

        if (!$oldCategoria)
        {
            return response()->json(['errors' => array(['code' => 404, 'message' => 'Resource Not Found'])], 404);
        }
        
        $oldCategoria->delete();
        
        return response()->json(['status' => 'OK'], 200);        
    }
}
