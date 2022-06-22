<?php

namespace App\Http\Controllers;

use App\Models\employes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administration.formEmploye');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //ajouter d'un emplye dans la base de donnees

        $request->validate([
            'nom' => 'bail|required',
            'prenom' => 'bail|required',
            'matricule' => 'bail|required',
            'pass' => 'bail|required',
            'service' => 'bail|required'
        ]);
        DB::table('employes')
            ->updateOrInsert(
                ['nom' => htmlspecialchars($request->input('nom')),
                'prenom' => htmlspecialchars($request->input('prenom')),
                'pass'=> sha1(htmlspecialchars($request->input('pass'))),
                'service' =>htmlspecialchars($request->input('service'))
                ],
                ['matricule' => htmlspecialchars($request->input('matricule'))]
                );
                return back();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
