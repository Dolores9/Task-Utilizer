@extends('layouts.app')

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">

                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
        </div>
    @endif

    <div class="container">
        <h1 class="title-note">Your Notes</h1>

        <div class="notes-menu">
        <a href="{{ route('notes.create') }}" class="button">Create Note</a>
        <a href="{{ route('tasks.index') }}" class="button">Go Back</a>
        </div>

            @foreach($notes as $note)
                <div class="card-notes">
                    <div class="card-body">
                        <h5 class="card-title">{{ $note->title }}</h5>
                        <p class="card-text">{{ $note->description }}</p>
                        <small class="text-created">Created on {{ $note->created_at->format('M d, Y') }}</small>

                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
    </div

@endsection
