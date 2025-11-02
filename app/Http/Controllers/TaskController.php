<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $user = auth()->user();

        $tasks = Task::where('user_id', $user->id)->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        $task = Task::find($id);

        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {

        $task = Task::find($id);
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
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

    /**
     * Search a specified resource from storage.
     */
    public function search(Request $request) {
        $search = $request->input('search');
        $filter = $request->input('priority');

        $query = Task::query()
            ->where('user_id', auth()->id());

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
