@extends('layouts.app')

@section('content')

<div class="container d-flex flex-column justify-content-center align-items-center" style="height: 50vh;">
    <h1 class="display-4 mb-4">Thank you for registering!</h1>
    <a href="{{ route('contacts.index') }}" class="btn btn-primary">Continue</a>
</div>

@endsection