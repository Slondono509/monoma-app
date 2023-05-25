<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use Illuminate\Http\Request;
use Auth;

class CandidatoController extends Controller
{

    public function index(){    
        $user = Auth::user();
        if($user->role === 'managers'){
            $Candidato = Candidato::latest()->get();     
        }else{
            $Candidato = Candidato::latest()->where('owner',$user->id)->get();         
        }
        return Response()->json([
            'meta' => array(
                "success"=> true,
                "errors"=> []
            ),
            'data' => $Candidato,
        ],201);   
    }

    public function show($id){
        $user = Auth::user();
        if($user->role === 'manager'){
            $Candidato = Candidato::find($id);
        }else{
            $Candidato = Candidato::where('id',$id)->where('owner',$user->id)->first();         
        }
        if($Candidato){        
            return Response()->json([
                'meta' => array(
                    "success"=> true,
                    "errors"=> []
                ),
                'data' => $Candidato,
            ],201);
        }else{
            return Response()->json([
                'meta' => array(
                    "success"=> false,
                    "errors"=> ["No lead found"]
                )                
            ],404);
        }   
    }

    public function store(Request $request)
    {
        $request->validate([        
            'name'=> 'required',
            'source' => 'required',
            'owner' => 'required',
        ]);
        $user = Auth::user();
        if($user->role === 'manager'){
            $dataCandidato = array('name' => $request->name, 'source' => $request->source, 'owner' => $request->owner, 'created_by' => $user->id);        
            $Candidato = Candidato::create($dataCandidato);
            return Response()->json([
                'meta' => array(
                    "success"=> true,
                    "errors"=> []
                ),
                'data' => $Candidato,
            ],201);    
        }else{
            return Response()->json([
                'meta' => array(
                    "success"=> false,
                    "errors"=> ["Unauthorized"]
                )                
            ],401);
        }              
    }

   
}
