@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
@endsection

@section('content')

    <div class="row w-100 h-100">
        <div class="col">
            <div class="row color4 p-4 mb-3 containerShadow2">
                <div class="col-md-2 d-flex justify-content-center justify-content-md-start">
                    <div class="profile-container">
                        <form id="profile-form" action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label for="fileUpload" class="upload-label">
                                @if ($employee->profile_image)
                                    <img id="profileImage" src="data:image/jpeg;base64,{{ base64_encode($employee->profile_image) }}" class="img-fluid profile-pic" alt="Profile Image">
                                @else
                                    <span class="no-image">No image</span>
                                @endif
                                <span class="upload-icon">
                                    <i class="fa-solid fa-image"></i>
                                </span>
                                <span class="upload-text">Upload Image</span>
                            </label>
                            <input type="file" id="fileUpload" name="profile_image" accept="image/*" style="display:none;">
                        </form>
                    </div>
                </div>
                <div class="col-md-10 mt-3 mt-md-0 d-flex justify-content-center justify-content-md-start">
                    <div class="row align-items-center">
                        <div class="col text-center text-md-start">
                            <div class="row">
                                <div class="col" style="font-size: 1.5rem; font-weight: bold;">
                                    {{$employee->name}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    {{$employee->role}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <form action="{{ route('updateBio') }}" method="post">
                @csrf
                <div class="row color4 p-4 mb-3 containerShadow2">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <h1>About Me</h1>
                                <hr>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <textarea class="form-control full-width-textarea color4" rows="5" placeholder="-- Click to add Bio --" name="bio">{{ $employee->bio }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-end">
                                <button class="btn btn-outline-light">Save</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </form>
        
            <form action="{{ route('updatePersonalInfo') }}" method="post">
                @csrf
                <div class="row color4 p-4 mb-3 containerShadow2">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <h1>Self Information</h1>
                                <hr>
                            </div>
                        </div>
                        @if(session('personal_update_success'))
                            <div class="alert alert-success">
                            {{ session('personal_info_success') }}
                        </div>
                        @endif
                        @if(session('personal_update_error'))
                            <div class="alert alert-danger">
                                {{ session('personal_info_error') }}
                            </div>
                        @endif
                        <div class="row p-2 align-items-center">
                            <div class="col-md-2">
                                Email: 
                            </div>
                            <div class="col-md-6">
                               <input type="text" class="form-control color4" name="email" id="email" value="{{ $employee->email }}"> 
                            </div>
                        </div>
                        <div class="row p-2 align-items-center">
                            <div class="col-md-2">
                                Address: 
                            </div>
                            <div class="col-md-6">
                               <input type="text" class="form-control color4" name="address" id="address" value="{{ $employee->address }}"> 
                            </div>
                        </div>
                        <div class="row p-2 align-items-center">
                            <div class="col-md-2">
                                Contact Number: 
                            </div>
                            <div class="col-md-6">
                               <input type="text" class="form-control color4" name="contact_number" id="contact_number" value="{{ $employee->contact_number }}"> 
                            </div>
                        </div>
                        <div class="row p-2 align-items-center">
                            <div class="col-md-2">
                                Emergency Contact Number: 
                            </div>
                            <div class="col-md-6">
                               <input type="text" class="form-control color4" name="emergency_contact_number" id="emergency_contact_number" value="{{ $employee->emergency_contact_number }}"> 
                            </div>
                        </div>
                        <hr>
                        <div class="row p-2 align-items-center">
                            <div class="col-md-2">
                                Position: 
                            </div>
                            <div class="col-md-6">
                               <input type="text" class="form-control color4" name="position" id="position" value="{{ $employee->position }}"> 
                            </div>
                        </div>
                        <div class="row p-2 align-items-center">
                            <div class="col-md-2">
                                Department: 
                            </div>
                            <div class="col-md-6">
                               <input type="text" class="form-control color4" name="department" id="department" value="{{ $employee->department }}"> 
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col d-flex justify-content-end">
                                <button class="btn btn-outline-light">Update</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </form>
        
            <form action="{{ route('updateAccountInfo') }}" method="post">
                @csrf
                <div class="row color4 p-4 mb-3 containerShadow2">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <h1>Account Information</h1>
                                <hr>
                            </div>
                        </div>
                        @if(session('account_success'))
                            <div class="alert alert-success">
                            {{ session('password_update_success') }}
                            </div>
                        @endif
                        @if(session('account_error'))
                            <div class="alert alert-danger">
                                {{ session('password_update_error') }}
                            </div>
                        @endif
                        <div class="row p-2 d-flex align-items-center">
                            <div class="col-md-2">
                                Current Password: 
                            </div>
                            <div class="col-md-6">
                               <input type="password" class="form-control color5 @error('current_password') is-invalid @enderror" name="current_password" id="current_password"> 
                            </div>
                        </div>
                        <div class="row p-2 d-flex align-items-center">
                            <div class="col-md-2">
                                New Password: 
                            </div>
                            <div class="col-md-6">
                                <input type="password" class="form-control color5 @error('new_password') is-invalid @enderror" name="new_password" id="new_password"> 
                             </div>
                        </div>
                        <div class="row p-2 d-flex align-items-center">
                            <div class="col-md-2">
                                Confirm New Password: 
                            </div>
                            <div class="col-md-6">
                                <input type="password" class="form-control color5 @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" id="new_password_confirmation">
                                @error('new_password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-end">
                                <button class="btn btn-outline-light">Update</button>
                            </div> 
                        </div>
                    </div>
                </div>
            </form>
        
            <div class="modal fade" id="cropImageModal" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cropImageModalLabel">Crop Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container">
                                <img id="image" src="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="cropButton">Crop</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

