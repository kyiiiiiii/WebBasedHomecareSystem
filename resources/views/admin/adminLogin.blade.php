@extends('layouts.adminLogin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
    <div class="row justify-content-center p-5">
        <div class="col col-lg-4 textstyle p-5 mt-5 fade-in transparency containerShadow">
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="row mb-3" style="text-align: center">
                    <div class="col">
                        <h1>Admin Login</h1>
                    </div>
                </div>
                @if(session("admin_login_error"))
                    <div class="row mb-3 alert alert-danger">
                        {{ session('admin_login_error') }}
                    </div>
                @endif
                <div class="row p-4">
                    <div class="col d-flex align-items-center">
                        <i class="fas fa-user fa-1.5x me-2 icon-adjust"></i>
                        <input type="text" class="transparency3 col-11 padding textfield2 textstyle"  name="email" id="email" required autocomplete="adminUsername" autofocus placeholder="USERNAME">
                    </div>
                </div>
                <div class="row p-4">
                    <div class="col d-flex align-items-center">
                        <i class="fa-solid fa-key fa-1.5x me-2 icon-adjust"></i>
                        <input type="password" class="transparency3 padding col-11 textfield2 textstyle" name="password" id="password" required autocomplete="adminPassword" autofocus placeholder="PASSWORD">
                    </div>
                </div>
                <div class="row mb-2 p-4 justify-content-center gap-5" style="text-align: center">
                    <a href="{{ route('patient.login') }}" type="submit" class="btn btn-outline-light col-4 d-flex justify-content-center">Back</a>
                    <button type="submit" class="btn btn-outline-light col-4 d-flex justify-content-center align-items-center">Login</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection