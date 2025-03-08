@extends('layouts.admin') <!-- If you have a layout, extend it -->

@section('title', 'Access Denied')

@section('content')
    <div class="container text-center" style="margin-top: 100px;">
        <h1 class="display-4">403 - Access Denied</h1>
        <p class="lead">Sorry, you do not have permission to access this page.</p>
        <a href="{{ route('showAdminHome') }}" class="btn btn-primary">Return to Home</a>
    </div>
@endsection