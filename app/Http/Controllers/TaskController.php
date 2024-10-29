<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        Task::create($request->only('title', 'description'));

        return redirect('/')->with('success', 'Task created successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/')->with('success', 'Task deleted successfully.');
    }

}
