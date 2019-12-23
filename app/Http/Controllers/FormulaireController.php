<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Formulaire;
use App\Http\Resources\Formulaire as FormulaireResource;

class FormulaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Formulaires
        $formulaires = Formulaire::orderBy('created_at', 'desc')->paginate(2);

        // Return collection of Formulaires as a resource
        return FormulaireResource::collection($formulaires);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formulaire = $request->isMethod('put') ? Formulaire::findOrFail($request->formulaire_id) : new Formulaire;

        $formulaire->id = $request->input('Formulaire_id');
        $formulaire->choix = $request->input('choix');
        $formulaire->response1 = $request->input('response1');
        $formulaire->response2 = $request->input('response2');
        $formulaire->response3 = $request->input('response3');
        $formulaire->body = $request->input('body');

        if($formulaire->save()) {
            return new FormulaireResource($formulaire);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get Formulaire
        $formulaire = Formulaire::findOrFail($id);

        // Return single Formulaire as a resource
        return new FormulaireResource($formulaire);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get Formulaire
        $formulaire = Formulaire::findOrFail($id);

        if($formulaire->delete()) {
            return new FormulaireResource($formulaire);
        }    
    }
}
