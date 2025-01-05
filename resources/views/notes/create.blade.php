@extends('layouts.app')

@section('content')
    <div class="container-notes">
                <div class="card">
                    <div class="card-header">
                        <h3>Create a New Note</h3>
                    </div>
                    <div class="card-body-create">
                        <form action="{{ route('notes.store') }}" method="POST">
                            @csrf

                            <div class="form-title-note">
                                <label for="title" class="form-label">Title</label>
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    class="form-control"
                                    placeholder="Enter note title"
                                    required>
                            </div>

                            <!-- Description Field -->
                            <div class="form-description-note">
                                <label for="description" class="form-label">Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Enter note description"
                                    required></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Create Note</button>
                                <a href="{{ route('notes.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
    </div>
@endsection
