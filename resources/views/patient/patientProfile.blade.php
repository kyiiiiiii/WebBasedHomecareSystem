@extends('layouts.patient')

@section('styles')
<style>
.background-white{
    background-color: white;
}
</style>
@endsection

@section('content')
<div class="w-100 h-100 ">
    <div class="row background-white p-4 mb-3 containerShadow2">
        <!-- Profile picture upload -->
        <div class="col-md-2 d-flex justify-content-center justify-content-md-start">
            <div class="profile-container">
                <form id="profile-form" action="{{ route('updatePatientProfilePicture') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label for="fileUpload" class="upload-label">
                        @if ($patientAccount->profile_picture)
                            <img id="profileImage" src="data:image/jpeg;base64,{{ base64_encode($patientAccount->profile_picture) }}" class="img-fluid profile-pic" alt="Profile Image">
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
                            {{$patient->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('updatePatientBio') }}" method="post">
        @csrf
        <div class="row background-white p-4 mb-3 containerShadow2">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <h1>About Me</h1>
                        <hr>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <textarea class="form-control full-width-textarea background-white" rows="5" placeholder="-- Click to add Bio --" name="bio">{{$patient->bio}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-dark color7">Save</button>
                    </div> 
                </div>
            </div>
        </div>
    </form>
    <form action="{{ route('updatePatientPersonalInfo') }}" method="post">
        @csrf
        <div class="row background-white p-4 mb-3 containerShadow2">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <h1>Self Information</h1>
                        <hr>
                    </div>
                </div>
                @if(session('personal_info_success'))
                    <div class="alert alert-success">
                    {{ session('personal_info_success') }}
                </div>
                @endif
                @if(session('personal_info_error'))
                    <div class="alert alert-danger">
                        {{ session('personal_info_error') }}
                    </div>
                @endif
                <div class="row p-2 align-items-center">
                    <div class="col-md-2">
                        Date Of Birth: 
                    </div>
                    <div class="col-md-6">
                       <input type="date" class="form-control background-white @error('dob') is-invalid @enderror" name="dob" id="dob" value="{{$patient->date_of_birth}}"> 
                    </div>
                </div>
                <div class="row p-2 align-items-center">
                    <div class="col-md-2">
                        Gender: 
                    </div>
                    <div class="col-md-6">
                       <input type="text" class="form-control background-white @error('gender') is-invalid @enderror" name="gender" id="gender" value="{{$patient->gender}}"> 
                    </div>
                </div>
                <div class="row p-2 align-items-center">
                    <div class="col-md-2">
                        Email: 
                    </div>
                    <div class="col-md-6">
                       <input type="text" class="form-control background-white @error('email') is-invalid @enderror" name="email" id="email" value="{{$patient->email}}"> 
                    </div>
                </div>
                <div class="row p-2 align-items-center">
                    <div class="col-md-2">
                        Contact Number: 
                    </div>
                    <div class="col-md-6">
                       <input type="text" class="form-control background-white @error('contact') is-invalid @enderror" name="contact" id="contact" value="{{$patient->contact}}"> 
                    </div>
                </div>
                <hr>
                
                <div class="row p-2 align-items-center">
                    <div class="col-md-2">
                        Address Line 1: 
                    </div>
                    <div class="col-md-6">
                       <input type="text" class="form-control background-white @error('address_line_1') is-invalid @enderror" name="address_line_1" id="address_line_1" value="{{$patient->address_line_1}}"> 
                    </div>
                </div>
                <div class="row p-2 align-items-center">
                    <div class="col-md-2">
                        Address Line 2: 
                    </div>
                    <div class="col-md-6">
                       <input type="text" class="form-control background-white @error('address_line_2') is-invalid @enderror" name="address_line_2" id="address_line_2" value="{{$patient->address_line_2}}"> 
                    </div>
                </div>
                <div class="row p-2 align-items-center">
                    <div class="col-md-2">
                        City :
                    </div>
                    <div class="col-1">
                       <input type="text" class="form-control background-white @error('city') is-invalid @enderror" name="city" id="city" value="{{$patient->city}}"> 
                    </div>
                    <div class="col-md-1">
                        State :
                    </div>
                    <div class="col-1">
                       <input type="text" class="form-control background-white @error('state') is-invalid @enderror" name="state" id="state" value="{{$patient->state}}"> 
                    </div>
                    <div class="col-md-1">
                        Postal :
                    </div>
                    <div class="col-1">
                       <input type="text" class="form-control background-white @error('postal_code') is-invalid @enderror" name="postal_code" id="address" value="{{$patient->postal_code}}"> 
                    </div>
                </div>
                
                <div class="row p-2">
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-dark color7">Update</button>
                    </div> 
                </div>
            </div>
        </div>
    </form>
    <form action="{{ route('updatePatientAccountInfo') }}" method="post">
        @csrf
        <div class="row background-white p-4 mb-3 containerShadow2">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <h1>Account Information</h1>
                        <hr>
                    </div>
                </div>
                @if(session('password_update_success'))
                    <div class="alert alert-success">
                    {{ session('password_update_success') }}
                    </div>
                @endif
                @if(session('password_update_error'))
                    <div class="alert alert-danger">
                        {{ session('password_update_error') }}
                    </div>
                @endif
                <div class="row p-2 d-flex align-items-center">
                    <div class="col-md-2">
                        Current Password: 
                    </div>
                    <div class="col-md-6">
                       <input type="password" class="form-control background-white @error('current_password') is-invalid @enderror" name="current_password" id="current_password"> 
                    </div>
                </div>
                <div class="row p-2 d-flex align-items-center">
                    <div class="col-md-2">
                        New Password: 
                    </div>
                    <div class="col-md-6">
                        <input type="password" class="form-control background-white @error('new_password') is-invalid @enderror" name="new_password" id="new_password"> 
                     </div>
                </div>
                <div class="row p-2 d-flex align-items-center">
                    <div class="col-md-2">
                        Confirm New Password: 
                    </div>
                    <div class="col-md-6">
                        <input type="password" class="form-control background-white @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" id="new_password_confirmation">
                        @error('new_password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-dark color7">Update</button>
                    </div> 
                </div>
            </div>
        </div>
        
    </form>
</div>
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
@endsection

@section('scripts')
@endsection