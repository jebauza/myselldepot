<?php

namespace App\Http\Controllers\CMS\Api;

use App\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\Message\NewMessageEvent;

class ChatApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getContacts(Request $request)
    {
        $currentUser = $request->user();

        $contacts = User::where('id', '<>', $currentUser->id)
                        ->with('profileImage')
                        ->get(['id', 'firstname', 'secondname', 'lastname']);

        return response()->json($contacts, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getMessages(Request $request, $contact_id)
    {
        $currentUser = $request->user();
        if (!$contact = User::find($contact_id)) {
            return response()->json(['msg_error' => __('Not found')], 404);
        }

        $messages = Message::fromAndTo($currentUser->id, $contact->id)
                            ->with('fromUser.profileImage', 'toUser.profileImage')
                            ->oldest()
                            ->get();

        return response()->json($messages, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'contact' => 'required|integer|exists:users,id',
            'text' => 'required|string'
        ]);

        $newMessage = Message::create([
            'from' => $request->user()->id,
            'to' => $request->contact,
            'text' => $request->text
        ]);

        //broadcast(new NewMessageEvent($newMessage));  // ->toOthers();
        return response()->json($newMessage->loadWithFromAndTo(), 201);
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
