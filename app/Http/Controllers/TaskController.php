<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch tasks for the current user
        $tasks = Task::where('user_id', $user->id)->get();

        // Ensure that you can access completed_tasks
        if (property_exists($user, 'completed_tasks')) {
            $showNotesField = $user->completed_tasks >= 5;
        } else {
            $showNotesField = false; // Default to false if the property doesn't exist
        }



        return view('tasks.index', compact('tasks', 'showNotesField'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|boolean',
            'due_date' => 'required|date',
        ]);


        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'priority' => $request->priority,
            'due_date' => $request->due_date,
        ]);

        return redirect('tasks')->with('success', 'Task created successfully.');
    }

    public function destroy(Task $task)
    {
        $task->increment('completed_count');

        if ($task->completed_count === 1) {
            $user = auth()->user();
            $user->increment('completed_tasks');
        }

        $task->delete();
        return redirect('tasks')->with('success', 'Task deleted successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $task->update([
            'notes' => $request->notes,
        ]);

        return redirect()->route('tasks')->with('success', 'Task updated successfully!');
    }



}
