<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="container">
    <h1>Your Tasks</h1>

    <!-- Add account menu -->
    <div class="account-menu">
        @auth
            <p>Welcome, <strong>{{ Auth::user()->name }}</strong>!</p>

            {{-- Check if the user is an admin --}}
            @if(Auth::user()->admin)
                <form action="{{ route('admin.dashboard') }}" method="GET" style="display: inline;">
                    <button type="submit" class="button">Admin Dashboard</button>
                </form>
            @endif

            <form action="{{ route('notes.index') }}" method="GET" style="display: inline;">
                <button type="submit" class="button">View Notes</button>
            </form>

            <form action="{{ route('profile.edit') }}" method="GET" style="display: inline;">
                <button type="submit" class="button">Profile</button>
            </form>


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
        <form action="{{ route('tasks.search') }}" method="GET" style="display: flex; align-items: center;">
            <input type="text" name="search" placeholder="Search tasks..." value="{{ request('search') }}" style="margin-right: 10px;">
            <select name="priority" style="margin-right: 10px;">
                <option value="">All Priorities</option>
                <option value="1" {{ request('priority') == '1' ? 'selected' : '' }}>High</option>
                <option value="0" {{ request('priority') == '0' ? 'selected' : '' }}>Low</option>
            </select>
            <button type="submit" class="button">Search</button>
        </form>
        <form action="{{ route('tasks.index') }}" method="GET" style="display: inline;">
            <button type="submit" class="button">Reset</button>
        </form>
    </div>

    <!-- Add Task Form -->
    <div class="container-task-form" style="background-color: #f5f5f5; padding: 20px;">
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
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 10px;">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            </div>

            <div style="margin-bottom: 10px;">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" value="{{ old('description') }}" required style="padding: 0 20px 20px 0">
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
                <div class="task-actions">
                    <form action="/tasks/{{ $task->id }}/edit" method="GET">
                        <button type="submit" class="button">Edit</button>
                    </form>
                    <form action="/tasks/{{ $task->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button">Complete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
