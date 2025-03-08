@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
    
        <div class="row containerShadow2 p-md-5 p-3 h-100 w-100" style="background-color: #e9ecef">
            <form action="{{ route('addAppointment') }}" method="POST">
                @csrf
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h1>Add New Appointment</h1>
                            <hr>
                        </div>
                    </div>
                    
                    @if(session("add_appoinment_success"))
                        <div class="alert alert-success">
                            {{ session('add_appoinment_success') }}
                        </div>
                    @endif
                    
    
                    <!-- Patient ID Field -->
                    <div class="row align-items-center mb-sm-3 mb-2">
                        <div class="col-sm-2">
                            Patient ID:
                        </div>
                        <div class="col">
                            <input type="text" name="patientID" id="patientID" class="form-control @error('patientID') is-invalid @enderror">
                            <div id="patientIDFeedback"></div> <!-- Feedback message for validation -->
                        </div>
                    </div>
    
                    <!-- Other Appointment Fields -->
                    <div class="row align-items-center mb-sm-3 mb-2">
                        <div class="col-sm-2">
                            Appointment Type:
                        </div>
                        <div class="col-sm align-items-center mb-sm-0 mb-2">
                            <select name="type" id="type" class="form-select">
                                <option value="MedicalCheckUp">Medical Checkup</option>
                                <option value="Telemedicine">Telemedicine</option>
                                <option value="SpecialistConsultation">Specialist Consultation</option>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            Date:
                        </div>
                        <div class="col-sm mb-sm-0 mb-2">
                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row align-items-center mb-sm-3 mb-2">
                        <div class="col-sm-2">
                            Appointment Time:
                        </div>
                        <div class="col-sm">
                            <input type="time" name="time" id="time" class="form-control @error('time') is-invalid @enderror" style="width: 50%" >
                        </div>
                    </div>
                    <div class="row mb-sm-3 mb-2">
                        <div class="col-sm-2">
                            Notes:
                        </div>
                        <div class="col-sm">
                            <textarea name="notes" id="notes" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    
                    <!-- Form Submission Buttons -->
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-end align-items-center">
                            <a href="/appointment" class="btn btn-outline-danger px-4 mx-3">Back</a>
                            <button type="submit" class="btn btn-outline-dark px-4">Add</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
   

    <!-- JavaScript for real-time validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const patientIDInput = document.getElementById('patientID');
    
            patientIDInput.addEventListener('input', function() {
                // Reset previous classes
                patientIDInput.classList.remove('is-valid', 'is-invalid');
    
                // Check if the input value is empty
                if (this.value.trim() === '') {
                    // If empty, no need for further validation
                    return;
                }
    
                // Validate patient ID asynchronously
                fetch(`/validatePatientID/${this.value}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            // Patient ID exists
                            patientIDInput.classList.add('is-valid');
                        } else {
                            // Patient ID does not exist
                            patientIDInput.classList.add('is-invalid');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>

@endsection
