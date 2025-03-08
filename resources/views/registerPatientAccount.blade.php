@extends('layouts.login')


@section('content')

<form action="{{ route('registerPatientAccount') }}" method="POST">
    @csrf

    <div class="row px-5 pt-1">
        <div class="col px-5" >
            <div class="card" style="background-color: rgb(247, 247, 247)">
                <div class="card-header">
                  Patient Registration
                </div>
                <div class="card-body">
                  <h5 class="card-title">Register a new patient</h5>
                  <p class="card-text">
                    Please fill out the following form to register a new patient in the system.
                  </p>
                  @if(session("patient_register_error"))
                        <div class="alert alert-danger">
                            {{ session('patient_register_error') }}
                        </div>
                    @endif
                  <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                First Name
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <input type="text" name="first_name" id="first_name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                Last Name
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <input type="text" name="last_name" id="text" class="form-control">
                            </div>
                        </div>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                Gender
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <select name="gender" id="gender" class="form-select">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                Date Of Birth
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <input type="date" name="dob" id="date" class="form-control">
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                Email
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                Contact
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <input type="text" name="contact" id="contact" class="form-control">
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                Address line 1
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <input type="text" name="address_line_1" id="date" class="form-control">
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                Address line 2
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <input type="text" name="address_line_2" id="date" class="form-control">
                            </div>
                        </div>
                        <hr>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                        Username
                    </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Password
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Confirm Password
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col mb-2">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                    </div>
                
                    <div class="row p-2 gap-3">
                        <a href="/" class="col btn btn-outline-dark">Back</a>
                        <button type="submit" class="col btn btn-dark">Register</button>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</form>      

@endsection
