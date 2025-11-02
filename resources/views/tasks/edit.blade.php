@extends('layouts.app')

@section('content')
    <div class="task-form-container">
        <h2>Edit your Task</h2>
        <form action="{{ route('tasks.update', $task->id )}}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" id="id" value="{{ $task->id }}"/>
            <div class="form-group">
                <label for="task-title" class="form-label">Title</label>
                <input
                    type="text"
                    id="task-title"
                    name="title"
                    class="task-title"
                    value="{{ old('title', $task->title) }}"
                placeholder="{{ $task->title }}"
                required>
            </div>


            <div class="form-group">
                <label for="task-description" class="form-label">Description</label>
                <textarea
                    id="task-description"
                    name="description"
                    class="task-description"
                    placeholder="{{ $task->description }}"
                required>{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="task-submit-btn">Edit Task</button>
                <a href="{{ route('tasks.index') }}" class="button">Cancel</a>
            </div>
        </form>
    </div>
@endsection
