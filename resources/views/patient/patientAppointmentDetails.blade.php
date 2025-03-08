@extends('layouts.patient')

@section('styles')
@endsection

@section('content')

<div class="row p-3 containerShadow2 h-100 w-100" style="background-color: #e9ecef">
    <div class="col">
        <div class="row">
            <div class="col">
                <h1>Appointment Details</h1>
                <hr>
            </div>
        </div>
        <div class="row mb-3 ">
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Patient Name : {{$appointment->patient->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Patient ID : {{$appointment->patient->id}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem">
                        Appointment ID : {{$appointment->id}}
                    </div>
                </div>
                <div class="row">
                    <div class="col" >
                        Appointment Type : {{$appointment->appointment_type}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Location : {{$appointment->location}}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem;">
                        Appointment Date: <span style="color: blue;">{{$appointment->appointment_date}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="font-weight: bold; font-size: 1rem;">
                        @php
                            $formattedTime = date('g:i A', strtotime($appointment->appointment_time));
                        @endphp
                        Appointment Time: <span style="color: blue;">{{$formattedTime}}</span>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="row">
                    <div class="col d-flex align-items-center" style="font-weight: bold; font-size: 1rem">
                        Healthcare Professional Assigned : 
                        @if($appointment->employee)
                            {{ $appointment->employee->name }}
                        @else
                            Pending
                        @endif
                    </div>
                    <div class="col">
                        @if($appointment->employee)
                            <a href="{{route('getCaregiverDetails', $appointment->assigned_employee_id) }}" class="btn btn-outline-dark">View</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col" style="font-weight: bold; font-size: 1rem">
                    Status : 
                    @if($appointment->status === 'pending')
                        {{$appointment->status}}<i class="ms-1 fa-regular fa-clock" style="color: rgb(4, 17, 130)"></i>
                    @elseif($appointment->status === 'completed')
                        {{$appointment->status}}<i class="ms-1 fa-solid fa-check-double" style="color: rgb(68, 253, 68)"></i>
                    @elseif($appointment->status === 'approved')
                        {{$appointment->status}}<i class="ms-1 fa-solid fa-check" style="color: rgb(68, 253, 68)"></i>
                    @endif
                </div>
            </div>
            
        </div>
        <hr>
        <div class="row mb-3">
            
            <div class="col">
                <div class="row">
                    <div class="col mb-1" style="font-weight: bold; font-size: 1rem">
                        Notes : 
                    </div> 
                </div>
                <div class="row">
                    <textarea name="notes" id="notes" cols="30" rows="5" class="form-control col" disabled style="background-color: white">{{$appointment->notes}}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection