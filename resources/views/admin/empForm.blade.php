@extends('layouts.admin')

@section('styles')
@endsection

@section('content')
<div class="row containerShadow3 p-4 h-100 w-100" style="background-color: #e9ecef">
    <div class="col">
        <div class="row">
            <h1 class="col">
                Add New Employee
            </h1>
            <hr>
        </div>
        @if($errors->any())
            <div class="row">
                <span class="col" style="color: red">* Please fill in the required field</span>
            </div>
        @endif
        <form action="{{ route('empForm') }}" method="POST" class=" textstyle3">
            @csrf
            <div class="row">
                <div class="col ">
                    <div class="row p-md-3 mb-1 mb-md-0">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-sm-2" class="">
                                    <label for="empName" >Full Name: </label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control @error('empName') is-invalid @enderror" name="empName" id="empName"/>
                                </div>
                            </div>   
                        </div>
                    </div>
                    
                    <div class="row p-md-3 mb-1 mb-md-0">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-sm-2 ">
                                    <label for="birthdate" >Date of Birth:</label>
                                </div>
                                <div class="col">
                                    <input type="date" name="birthdate" class="form-control text-center @error('birthdate') is-invalid @enderror"/>
                                </div>
                                <div class="col-sm-1 ">
                                    <label for="gender" >Gender: </label>
                                </div>
                                <div class="col align-items-center">
                                    <select name="gender" id="gender" class="form-select ">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="row p-md-3 mb-1 mb-md-0">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-sm-2">
                                    <label for="religion">Race: </label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control @error('race') is-invalid @enderror" name="race" id="race" />
                                </div>
                                <div class="col-sm-1">
                                    <label for="religion">Religion: </label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control @error('religion') is-invalid @enderror" name="religion" id="religion"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-md-3 mb-1 mb-md-0">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-sm-2">
                                    <label for="address">Address: </label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address"/>
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class="row p-md-3 mb-1 mb-md-0">
                        <div class="col">
                            <div class="row align-items-centers">
                                <div class="col-sm-2 ">
                                    <label for="state">State: </label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" id="state"/>
                                </div>
                                <div class="col-sm-1">
                                    <label for="city">City: </label>
                                </div>
                                <div class="col ">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city"/>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col ">
                    <div class="col">
                        <div class="row p-md-3 align-items-center mb-1 mb-md-0">
                            <div class="col-sm-2 ">
                                <label for="gender">Type: </label>
                            </div>
                            <div class="col ">
                                <select name="type" id="type" class="form-select">
                                    <option value="FullTime">Full Time</option>
                                    <option value="PartTime">Part Time</option>
                                </select>
                            </div>
                        </div>
                        <div class="row p-md-3 mb-1 mb-md-0">
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-sm-2"><label for="department">Department: </label></div>
                                    <div class="col-sm"><input type="text" name="department" id="department" class="form-control @error('department') is-invalid @enderror"></div>
                                </div>
                            </div>
                        </div>  
                        <div class="row p-md-3 mb-1 mb-md-0">
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-sm-2"><label for="admissionDate">Admission Date: </label></div>
                                    <div class="col-sm"><input type="date" name="admissionDate" id="contact" class=" form-control text-center @error('admissioDate') is-invalid @enderror"></div>
                                    <div class="col-sm-1"><label for="role">Role: </label></div>
                                    <div class="col-sm"><input type="text" name="role" id="role" class="form-control @error('role') is-invalid @enderror"></div>
                                </div>
                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col ">
                    <div class="col">
                        <div class="row p-md-3 mb-1 mb-md-0">
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-sm-2"><label for="empEmail">Email: </label></div>
                                    <div class="col-sm"><input type="email" name="empEmail" id="empEmail" class="form-control @error('empEmail') is-invalid @enderror"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-md-3 mb-1 mb-md-0">
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-sm-2"><label for="contact">Contact Number: </label></div>
                                    <div class="col-sm"><input type="text" name="contact" id="contact" class="mb-2 form-control @error('contact') is-invalid @enderror"></div>
                                    <div class="col-sm-2"><label for="Econtact">Emergency Contact Number: </label></div>
                                    <div class="col-sm"><input type="text" name="Econtact" id="Econtact" class="form-control @error('Econtact') is-invalid @enderror"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-md-3 mb-1 mb-md-0">
                            <div class="col">
                                <div class="row align-items-center mb-5">
                                    <div class="col-sm-2"><label for="Ename">Emergency Contact Name:</label></div>
                                    <div class="col-sm"><input type="text" name="Ename" id="Ename" class="form-control @error('Ename') is-invalid @enderror"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <a href="{{route("empInfo")}}" class="btn btn-outline-dark col me-3">Back</a>
                        <button type="submit" class="btn btn-outline-dark col">Add</button>
                    </div>
                </div>
            </div>
        </form> 

    </div>
</div>
@endsection
