@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')

<div class="row w-100 h-100" style="background-color: white">
    <div class="col-md-3 pt-5 p-4" style="border-right: 1px solid grey;">
        <div class="row mb-1">
            <div class="col d-flex justify-content-center">
                <div>
                    <form id="new-profile-form" action="{{ route('updateNewEmployeePicture', ['id' => $employee->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <label for="newFileUpload" class="upload-label2 containerShadow2 d-flex align-items-center justify-content-center">
                            @if ($employee->profile_image)
                                <img id="newProfileImage" src="data:image/jpeg;base64,{{ base64_encode($employee->profile_image) }}" class="img-fluid" alt="Click to upload Image">
                            @else
                                <span class="no-image">No image</span>
                            @endif
                            <span class="upload-icon">
                                <i class="fa-solid fa-image"></i>
                            </span>
                            <span class="upload-text">Upload Image</span>
                        </label>
                        <input type="file" id="newFileUpload" name="profile_image" accept="image/*" style="display:none;">
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col px-2">
                <div class="row p-2 justify-content-center mb-3">
                    {{$employee->name}}
                </div>
                <div class="row">
                    <div class="col-sm color8 mb-2">
                        <div class="row ps-1 pt-1">
                            <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">ID</div>
                        </div>
                        <div class="row px-1 pb-2">
                            <input type="text" name="id" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->id}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm color8 mb-2">
                        <div class="row ps-1 pt-1">
                            <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">ADMISSION DATE</div>
                        </div>
                        <div class="row px-1 pb-2">
                            <input type="text" name="admission_date" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->admission_date}}" readonly>
                        </div>
                    </div>
                </div>                      
                <div class="row">
                    <div class="col-sm color8 mb-2">
                        <div class="row ps-1 pt-1">
                            <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">ROLE</div>
                        </div>
                        <div class="row px-1 pb-2">
                            <input type="text" name="role" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->role}}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm color8 mb-2">
                        <div class="row ps-1 pt-1">
                            <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">DEPARTMENT</div>
                        </div>
                        <div class="row px-1 pb-2">
                            <input type="text" name="department" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->department}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <form id="personalDataForm" action="{{ route('updateEmployeeData', ['id' => $employee->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row px-3">
                <div class="col">
                    <div class="row">
                        <h1 class="col p-3">Personal Data</h1>
                        <a href="#" id="editPersonalData" class="col d-flex justify-content-end align-items-center">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">FULL NAME</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="name" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->name}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row gap-2">
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">BIRTHDATE</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="dob" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->dob}}" readonly>
                            </div>
                        </div>
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">NATIONALITY</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="race" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->race}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row gap-2">
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">GENDER</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="gender" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->gender}}" readonly>
                            </div>
                        </div>
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">RELIGION</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="religion" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->religion}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">ADDRESS</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="address" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->address}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row gap-2">
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">STATE</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="state" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->state}}" readonly>
                            </div>
                        </div>
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">CITY</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="city" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->city}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-3">
                <div class="col">
                    <div class="row">
                        <h1 class="col px-3 pb-3">Contact Information</h1>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">EMAIL</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="email" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->email}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row gap-2">
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">CONTACT NUMBER</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="contact_number" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->contact_number}}" readonly>
                            </div>
                        </div>
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">EMERGENCY CONTACT NUMBER</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="emergency_contact_number" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->emergency_contact_number}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm color8 mb-2">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">EMERGENCY CONTACT NAME</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="emergency_contact_name" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$employee->emergency_contact_name}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col d-flex justify-content-end">
                            <a href="{{ route('empInfo') }}" class="btn btn-dark textstyle5 color2 px-5">Back</a>
                            <button type="submit" class="btn btn-success px-5 ms-1">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="newCropImageModal" tabindex="-1" role="dialog" aria-labelledby="newCropImageModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCropImageModal">Crop Image</h5>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editPersonalData = document.getElementById('editPersonalData');
    const personalDataForm = document.getElementById('personalDataForm');
    const saveButton = personalDataForm.querySelector('button[type="submit"]');
    const inputs = personalDataForm.querySelectorAll('input');

    
    saveButton.disabled = true;
    saveButton.hidden = true;

    if (editPersonalData) {
        editPersonalData.addEventListener('click', function(event) {
            event.preventDefault(); 

            let firstEditableInput = null;

            inputs.forEach(input => {
                if (input.name !== 'id' && input.name !== 'admission_date') {
                    const col = input.closest('.col-sm.color8.mb-2');
                    if (input.readOnly) {
                        input.readOnly = false;
                        if (col) col.style.border = '1px solid black'; 
                        if (!firstEditableInput) firstEditableInput = input;
                    } else {
                        input.readOnly = true;
                        if (col) col.style.border = 'none'; 
                    }
                }
            });

            if (firstEditableInput) {
                firstEditableInput.focus(); 
            }
            
        });
    }

    // Enable the save button when any input changes
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            saveButton.disabled = false;
            saveButton.hidden = false;
        });
    });
});
</script>

@endsection
