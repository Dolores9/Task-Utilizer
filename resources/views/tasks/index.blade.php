<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container">
    <h1>Your Tasks</h1>

    <!-- Add account menu -->
    <div class="account-menu">
        @auth
            <p>Welcome, <strong>{{ Auth::user()->name }}</strong>!</p>
            @if(Auth::user()->admin)
                <form action="{{ route('admin.dashboard') }}" method="GET" style="display: inline;">
                    <button type="submit" class="bg-blue">Admin Dashboard</button>
                </form>
            @endif
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="bg-red">Logout</button>
            </form>
        @else
            <p><a href="{{ route('login') }}" class="bg-gray">Login</a></p>
        @endauth
    </div>

    <!-- Search Form -->
    <div class="search-form">
        <form action="{{ route('dashboard') }}" method="GET">
            <input type="text" name="search" placeholder="Search tasks..." value="{{ request('search') }}">
            <button type="submit" class="bg-gray">Search</button>
        </form>
    </div>

    <!-- Add Task Form -->
    <div class="container" style="background-color: #f5f5f5; padding: 20px;">
        <h1>Add a Task</h1>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Task form -->
        <form action="{{ route('dashboard') }}" method="POST">
            @csrf
            <div style="margin-bottom: 10px;">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            </div>

            <div style="margin-bottom: 10px;">
                <label for="description">Description</label>
                <textarea name="description" id="description">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom: 10px;">
                <label for="priority">Priority</label>
                <input type="radio" id="priority_yes" name="priority" value="1" {{ old('priority') == '1' ? 'checked' : '' }}> Yes
                <input type="radio" id="priority_no" name="priority" value="0" {{ old('priority') == '0' ? 'checked' : '' }}> No
            </div>

            <div style="margin-bottom: 10px;">
                <label for="due_date">Due Date</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required>
            </div>

            <button type="submit">Add Task</button>
        </form>
    </div>


    <!-- List of tasks -->
    <div class="task-list">
        @foreach($tasks as $task)
            <div class="task-item">
                    <strong>{{ $task->title }}</strong>
                    <p>{{ $task->description }}</p>
                    <p>Priority: {{ $task->priority ? 'Yes' : 'No' }}</p>
                    <p>Due Date: {{ $task->due_date }}</p>
                    @if ($showNotesField)
                        <input type="text" name="notes[{{ $task->id }}]" placeholder="Add notes for this task">
                    @endif
                <div class="task-actions">
                    <form action="/tasks/{{ $task->id }}/edit" method="GET">
                        <button type="submit" class="bg-blue">Edit</button>
                    </form>
                    <form action="/tasks/{{ $task->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-yellow">Complete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
