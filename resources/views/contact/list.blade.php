@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Contacts') }}</span>
                    <div>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Search" name="search" id="search">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        </div>
                </div>

                <div class="card-body">
                    @if ($user_contacts->isEmpty())
                        <p>No contacts</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->company }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->phone }}</td>
                                        <td>
                                            <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <!-- <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">Delete</button>
                                            </form> -->
                                            <!-- Button to trigger modal -->
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $contact->id }}">
                                                Delete
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="deleteModal{{ $contact->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this contact?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $user_contacts->links('pagination::bootstrap-4') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
