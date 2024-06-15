<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // index
    public function index()
    {
        $notes = Note::all();
        return response()->json([
            'message' => 'Success',
            'data' => $notes,

        ],200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'is_pin' => 'required',
        ]);
        $note = Note::create($request->all());

        // image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $image_name);
            $note->image = $image_name;
            $note->save();
        }

        return response()->json([
            'message' => 'Success',
            'data' => $note,
        ],201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'is_pin' => 'required',
        ]);
        $note = Note::find($id);
        $note->update($request->all());

        // image
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $image_name);
            $note->image = $image_name;
            $note->save();
        }
        return response()->json([
            'message' => 'Success',
            'data' => $note,
        ],200);
    }

    public function destroy($id)
    {
        $note = Note::find($id);
        $note->delete();
        return response()->json([
            'message' => 'Success',
        ],200);
    }

    public function show($id)
    {
        $note = Note::find($id);
        return response()->json([
            'message' => 'Success',
            'data' => $note,
        ],200);
    }
}
