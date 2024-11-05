<h1>Admin Dashboard</h1>

    <h2>All Users</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                <td>
                    <form action="{{ route('users.toggleActive', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">{{ $user->active ? 'Deactivate' : 'Activate' }}</button>
                    </form>
                </td>
                <td>{{ $user->active }}</td>
                <td>
{{--                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit">Delete</button>--}}
{{--                    </form>--}}
                </td>
            </tr>
        @endforeach

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        </tbody>
    </table>

