<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TipoRespuesta;
use DB;
use Auth;

class TipoRespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposrespuesta = DB::table('tipos_respuesta as tr')
                            ->leftJoin('users as u1', 'u1.id', '=', 'tr.created_by')
                            ->leftJoin('users as u2', 'u2.id', '=', 'tr.updated_by')
                            ->select('tr.id', 'tr.tipo_respuesta', 'tr.created_at', 'tr.updated_at', 'u1.email as created_by', 'u2.email as updated_by')
                            ->whereNull('tr.deleted_at')
                            ->get();

        return response()->json(['tiposrespuesta' => $tiposrespuesta], 200);
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
            'tiporespuesta' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>array(['code'=>422, 'message'=>'Unprocessable Entity'])], 422);
        }
      
        $newTipoRespuesta = new TipoRespuesta();
        $newTipoRespuesta->tipo_respuesta = $request->tiporespuesta;        
        $newTipoRespuesta->created_by = Auth::guard('api')->user()->id;
        $newTipoRespuesta->updated_by = Auth::guard('api')->user()->id;
        $newTipoRespuesta->save();

        return response()->json(['tiporespuesta' => $newTipoRespuesta], 201);   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tiporespuesta = DB::table('tipos_respuesta as tr')
                           ->leftJoin('users as u1', 'u1.id', '=', 'tr.created_by')
                           ->leftJoin('users as u2', 'u2.id', '=', 'tr.updated_by')
                           ->select('tr.id', 'tr.tipo_respuesta', 'tr.created_at', 'tr.updated_at', 'u1.email as created_by', 'u2.email as updated_by')
                           ->where('tr.id', $id)
                           ->whereNull('tr.deleted_at')
                           ->take(1)
                           ->get();

        if ($tiporespuesta != null)
        {
            return response()->json(['tiporespuesta' => $tiporespuesta], 200);
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
            'tiporespuesta' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>array(['code'=>422, 'message'=>'Unprocessable Entity'])], 422);
        }

        $oldTipoRespuesta = TipoRespuesta::where('id', $id)->first();

        if (!$oldTipoRespuesta)
        {            
            return response()->json(['errors' => array(['code' => 404, 'message' => 'Resource Not Found'])], 404);
        }

        $oldTipoRespuesta->tipo_respuesta = $request->tiporespuesta;    
        $oldTipoRespuesta->updated_by = Auth::guard('api')->user()->id;
        $oldTipoRespuesta->save(); 

        return response()->json(['tiporespuesta' => $oldTipoRespuesta], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldTipoRespuesta = TipoRespuesta::where('id', $id)->first();

        if (!$oldTipoRespuesta)
        {
            return response()->json(['errors' => array(['code' => 404, 'message' => 'Resource Not Found'])], 404);
        }
        
        $oldTipoRespuesta->delete();

        return response()->json(['status' => 'OK'], 200);    
    }
}
