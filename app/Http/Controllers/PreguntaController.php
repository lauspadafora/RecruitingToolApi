<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pregunta;
use Validator;
use DB;
use Auth;

class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preguntas = DB::table('preguntas as p')
                       ->leftJoin('categorias as c', 'c.id', '=', 'p.id_categoria')
                       ->leftJoin('tipos_respuesta as tr', 'tr.id', '=', 'p.id_tipo_respuesta')
                       ->leftJoin('users as u1', 'u1.id', '=', 'p.created_by')
                       ->leftJoin('users as u2', 'u2.id', '=', 'p.updated_by')
                       ->select('p.id', 'p.pregunta', 'c.categoria', 'tr.tipo_respuesta', 'p.created_at', 'p.updated_at', 'u1.email as created_by', 'u2.email as updated_by')
                       ->whereNull('p.deleted_at')
                       ->get();

        return response()->json(['preguntas' => $preguntas], 200);
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
            'pregunta' => 'required|min:5',
            'categoria' => 'required',
            'tiporespuesta' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>array(['code'=>422, 'message'=>'Unprocessable Entity'])], 422);
        }
       
        $newPregunta = new Pregunta();
        $newPregunta->pregunta = $request->pregunta;        
        $newPregunta->id_categoria = $request->categoria;        
        $newPregunta->id_tipo_respuesta = $request->tiporespuesta;        
        $newPregunta->created_by = Auth::guard('api')->user()->id;
        $newPregunta->updated_by = Auth::guard('api')->user()->id;
        $newPregunta->save();

        return response()->json(['newPregunta' => $newPregunta], 201);        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pregunta = DB::table('preguntas as p')
                      ->leftJoin('categorias as c', 'c.id', '=', 'p.id_categoria')
                      ->leftJoin('tipos_respuesta as tr', 'tr.id', '=', 'p.id_tipo_respuesta')
                      ->leftJoin('users as u1', 'u1.id', '=', 'p.created_by')
                      ->leftJoin('users as u2', 'u2.id', '=', 'p.updated_by')
                      ->select('p.id', 'p.pregunta', 'c.categoria', 'tr.tipo_respuesta', 'p.created_at', 'p.updated_at', 'u1.email as created_by', 'u2.email as updated_by')
                      ->where('p.id', $id)
                      ->whereNull('p.deleted_at')
                      ->take(1)
                      ->get();


        if ($pregunta != null)
        {
            return response()->json(['pregunta' => $pregunta], 200);
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
            'pregunta' => 'required|min:5',
            'categoria' => 'required',
            'tiporespuesta' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>array(['code'=>422, 'message'=>'Unprocessable Entity'])], 422);
        }

        $oldPregunta = Pregunta::where('id', $id)->first();

        if (!$oldPregunta)
        {            
            return response()->json(['errors' => array(['code' => 404, 'message' => 'Resource Not Found'])], 404);
        }

        $oldPregunta->pregunta = $request->pregunta;    
        $oldPregunta->id_categoria = $request->categoria;  
        $oldPregunta->id_tipo_respuesta = $request->tiporespuesta;
        $oldPregunta->updated_by = Auth::guard('api')->user()->id;
        $oldPregunta->save(); 

        return response()->json(['pregunta' => $oldPregunta], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldPregunta = Pregunta::where('id', $id)->first();

        if (!$oldPregunta)
        {
            return response()->json(['errors' => array(['code' => 404, 'message' => 'Resource Not Found'])], 404);
        }
        
        $oldPregunta->delete();

        return response()->json(['status' => 'OK'], 200);   
    }
}
