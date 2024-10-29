<!DOCTYPE html>
<html>
<head>
    <title>Task Utilizer</title>
</head>
<body>
<h1>Task Utilizer</h1>

@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="/tasks" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Task Title" required>
    <textarea name="description" placeholder="Task Description"></textarea>
    <button type="submit">Add Task</button>
</form>

<ul>
    @foreach($tasks as $task)
        <li>
            {{ $task->title }}
            <form action="/tasks/{{ $task->id }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
</body>
</html>
