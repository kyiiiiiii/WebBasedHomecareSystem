@extends('layouts.patient')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
<div class="row w-100 h-100 align-items-center">
    <div class="col">
        <form action="{{ route('addPatientAppointment') }}" method="POST">
            @csrf
            <div class="row containerShadow2 p-md-5 p-3" style="background-color: #e9ecef; min-height:80vh">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h1>Add New Appointment</h1>
                            <hr>
                        </div>
                    </div>
                    
                    @if(session("add_patient_appointment_success"))
                        <div class="alert alert-success">
                            {{ session('add_patient_appointment_success') }}
                        </div>
                    @endif
                    @if(session("add_patient_appointment_error"))
                        <div class="alert alert-danger">
                            {{ session('add_patient_appointment_error') }}
                        </div>
                    @endif
                    
                    <div class="row align-items-center mb-sm-3 mb-2">
                        <div class="col-sm-2">
                            Patient Name:
                        </div>
                        <div class="col">
                            <input type="text" name="name" id="name" class="form-control @error('namez') is-invalid @enderror" value="{{$patient->name}}">
                            <div id="patientIDFeedback"></div> <!-- Feedback message for validation -->
                        </div>
                    </div>
        
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
                            <input type="time" name="time" id="time" class="form-control @error('time') is-invalid @enderror" style="width: 50%">
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
                    
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-end align-items-center">
                            <a href="{{ route('showPatientHome') }}" class="btn btn-outline-danger px-4 mx-3">Back</a>
                            <button type="submit" class="btn btn-outline-dark px-4">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection