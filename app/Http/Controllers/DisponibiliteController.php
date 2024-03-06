<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Programme;
use App\Gestions\GestionDisponibilite;
use App\Http\Requests\DisponibiliteCreateRequest;

class DisponibiliteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('signature.disponibilite', [
            'disponibilites' => Programme::whereNotNull("jour")->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('signature.rdv.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DisponibiliteCreateRequest $request, GestionDisponibilite $gestion)
    {
        return $gestion->store($request);
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
        return view('signature.rdv.edit', [
            'update' => Programme::whereUuid($id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DisponibiliteCreateRequest $request, GestionDisponibilite $gestion, $id)
    {
        return $gestion->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GestionDisponibilite $gestion, $id)
    {
        return $gestion->delete($id);
    }
}
