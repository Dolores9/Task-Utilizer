<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $tasks = Task::where('user_id', $user->id)->get();

        return view('tasks.index', compact('tasks'));

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

    public function destroy(Task $task, Id $id)
    {
        $task = Task::find($id);

        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->increment('completed_count');

        if ($task->completed_count === 1) {
            $user = auth()->user();
            $user->increment('completed_tasks');
        }

        $task->delete();
        return redirect('tasks')->with('success', 'Task deleted successfully.');
    }

    public function edit($id)
    {
        $task = Task::find($id);

        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.edit', compact('task'));
    }


    public function update(Request $request, Task $task)
    {
           $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|boolean',
            'due_date' => 'required|date',
        ]);

        $task = Task::find($request->id);

        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->priority = $request->input('priority');
        $task->due_date = $request->input('due_date');

        $task->save();

        // Redirect back to tasks page with success message
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('priority');

        $query = Task::query();

        if (!empty($search)) {
            $query->where('title', 'like', "%$search%");
        }

        if (!is_null($filter)) {
            $query->where('priority', $filter);
        }

        $tasks = $query->get();

        return view('tasks.index', ['tasks' => $tasks]);
    }





}
