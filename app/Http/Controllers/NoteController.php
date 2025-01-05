<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Note;
use App\Models\LoginLog;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::all();
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        $loginCount = LoginLog::where('user_id', Auth::id())->count();


        if ($loginCount < 5) {
            return redirect()->route('notes.index')
                ->withErrors('Je moet minimaal op 5 verschillende dagen ingelogd zijn om notities te plaatsen.');
        }

        return view('notes.create');
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create the note
        Note::create([
            'user_id' => Auth::id(), // Associate note with logged-in user
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        // Redirect to notes index with success message
        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    public function destroy(Note $note)
    {
        // Delete the note
        $note->delete();

        // Redirect back to the notes index with a success message
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }

}
