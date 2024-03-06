<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->createMessage();

        return view("parametrage.message.index", [
            'messages' => Message::get()
        ]);
    }

    public function createMessage()
    {
        if(!Message::count()) {

            Message::create([
                'titre' => "Paiement de cachier des charges ",
                'description' => "Cher/Chère promoteur-trice votre média a été ajouté avec succès. Vous avez 48h pour effectuer le paiement du cahier des charges. Le montant du cahier des charges est de 2 000 000 GNF.",
                'uuid' => Str::uuid(),
                'nom' => "message_paiement"
            ]);
        }


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
        //
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
        return view("parametrage.message.edit", [
            'message' => Message::where("uuid", $id)->first()
        ]);
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
        Validator::make($request->all(), [
            'titre' => 'required',
            'description' => 'required',
        ])->validate();

        $message = Message::where("uuid", $id)->first();

        if($message) {
            $message->update([
                'titre' => $request->titre,
                'description' => $request->description
            ]);

            $message = Message::where("uuid", $id)->first();
        }

        return response()->json([
            'status' => true,
            'message' => "Message mis à jour avec succès",
            'item' => $message
        ]);
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
