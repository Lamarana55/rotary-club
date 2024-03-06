<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\{Programme, Meeting, Media, Tracking};
use Illuminate\Support\Str;
use App\Http\Requests\MeetingCreateRequest;
use App\Gestions\GestionMeeting;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $meetings = Meeting::whereIn("media_id", function ($query){
            $query->from("media")->where("stape", "<", 7)->select("id")->get();
        })->where("annuler", false)->latest()->paginate(10);

        return view("meeting.index", [
            'meetings' => $meetings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("meeting.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeetingCreateRequest $request, GestionMeeting $gestion)
    {
        return $gestion->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $day = Carbon::parse($id)->locale('fr')->dayName;
        $day = Str::title($day);

        $programmes = Programme::whereJour($day)->get();

        return view("meeting.select_heure", [
            'date' => $id,
            'programmes' => $programmes,
            'formatDate' => dateFormat($id),
            'dayName' => $day,
            'media' => $request->media
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = false;
        $meeting = Meeting::find($id);
        if($meeting) {
            $status = true;
            $meeting->update([
                'confirmer' => true
            ]);

            $tracking = Tracking::where('media_id', $meeting->media_id)->first();
            if($tracking){
                $tracking->date_confirme_rdv = Carbon::now();
                $tracking->save();
            }
            $media = Media::where('id',$meeting->media_id)->first();
            $media->stape = 6;
            $media->current_stape = 7;
            $media->save();
        }

        send_notification(
            $meeting->media->user,
            "Confirmation rendez-vous",
            message_email("confirmation_rdv", $meeting),
            $media
        );

        return response()->json([
            'status' => true,
            'message' => "Vous avez confirmé le rendez-vous de ce promoteur pour la signature de sa convention d’établissement."
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
