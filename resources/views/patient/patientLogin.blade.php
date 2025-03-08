@extends('layouts.login')

@section('styles')

@endsection

@section('content')
<form action="{{ route('patient.login') }}" method="POST">
    @csrf
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row p-5 transparency m-4 containerShadow3 w-100 d-flex justify-content-center align-items-center" >
            <div class="col-lg-6 mt-5 p-5 d-none d-lg-block" style="border-right:1px solid white">
                <div class="row">
                    <div class="col">
                        <h1 class="textbig textstyle fade-in">Welcome<br> to the website</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="textmedium textstyle2 fade-in">Here for You, Because We Care</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="{{route("admin.login")}}" class="btn btn-outline-light fade-in">Login As Member</a>
                    </div>
                </div>
            </div>
    
            <div class="col-lg-6 py-5 d-flex justify-content-center align-items-center">
                <div class="w-100">
                    
                    <div class="row mb-4">
                        <div class="col fade-in d-flex justify-content-center align-items-center">
                            <h1>Sign In</h1>
                        </div>
                    </div>
                    
                    @if(session("patient_login_error"))
                        <div class="row px-md-5 px-0">
                            <div class="col d-flex justify-content-center align-items-center alert alert-danger">
                                {{ session('patient_login_error') }}
                            </div>
                        </div>
                    @endif
                    <div class="row mb-5 px-md-5 px-0">
                        <div class="col d-flex justify-content-center align-items-center">
                            <input type="email" name="email" id="email" class="textfield1 custom-placeholder p-1" style="width: 100%" placeholder="Email">
                        </div>
                    </div>
                    <div class="row mb-3 px-md-5 px-0">
                        <div class="col d-flex justify-content-center align-items-center">
                            <input type="password" name="password" id="password" class="textfield1 custom-placeholder p-1"style="width: 100%" placeholder="Password">
                        </div>
                    </div>
                   
                    <div class="row mb-4 px-5 ">
                        <div class="col">
                            
                        </div>
                        <div class="col d-flex justify-content-end ">
                            <a href="/registerPatientAccount" class="textstyle2 d-none d-sm-block">Register Now?</a>
                        </div>
                    </div>
                    <div class="row mb-2 px-5">
                        <div class="col d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-outline-light form-control">Login</button>
                        </div>
                    </div>
                    <div class="row p-1 d-sm-none ">
                        <div class="col d-flex justify-content-center align-items-center">
                            <a href="/adminLogin" class="textstyle2" style="font-size:0.75rem;">Login As Employee</a>
                        </div>
                    </div>
                    <div class="row mb-4 px-5 d-sm-none ">
                        <div class="col d-flex justify-content-center align-items-center">
                            <a href="/register" class="textstyle2" style="font-size:0.75rem;">Need Help ?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection