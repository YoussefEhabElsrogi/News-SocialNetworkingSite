@extends('layouts.dashboard.app')

@section('title', 'Show Contact')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Contact Information: {{ $contact->name }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Name</label>
                            <input type="text" id="name" class="form-control" value="{{ $contact->name }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Title</label>
                            <input type="text" id="title" class="form-control" value="{{ $contact->title }}"
                                disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input type="email" id="email" class="form-control" value="{{ $contact->email }}"
                                disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="font-weight-bold">Phone</label>
                            <input type="text" id="phone" class="form-control" value="{{ $contact->phone }}"
                                disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="body" class="font-weight-bold">Message</label>
                    <textarea id="body" class="form-control" rows="5" disabled>{{ $contact->body }}</textarea>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <!-- Reply Button -->
                    <a href="mailto:{{ $contact->email }}?subject=Re:{{ urlencode($contact->title) }}"
                        class="btn btn-primary">
                        <i class="fa fa-reply"></i> Reply
                    </a>
                    <!-- Delete Button -->
                    <a href="javascript:void(0)"
                        onclick="if(confirm('Do you want to delete the contact?')){document.getElementById('delete_contact').submit()} return false"
                        class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>

        <!-- Delete Form -->
        <form id="delete_contact" action="{{ route('dashboard.contacts.destroy', $contact->id) }}" method="post"
            style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
