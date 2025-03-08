@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
    <div class="row p-3 containerShadow2 h-100 w-100" style="background-color: #e9ecef">
        <div class="col">
            <div class="row">
                <div class="col">
                    <h1>Appointment Details</h1>
                    
                </div>
                <hr>
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
                <div class="col d-flex align-items-center">
                    <a href="{{route('viewPatientDetails',$appointment->id)}}" class="btn btn-outline-dark">View Patient</a>
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
                <div class="col ">
                    <div class="row">
                        <div class="col " style="font-weight: bold; font-size: 1rem">
                            Appointment Date : {{$appointment->appointment_date}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" style="font-weight: bold; font-size: 1rem">
                             
                            @php
                                $formattedTime = date('g:i A', strtotime($appointment->appointment_time));
                            @endphp
                            Appointment time : {{$formattedTime}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="row">
                        <div class="col" style="font-weight: bold; font-size: 1rem">
                            Healthcare Professional Assigned : {{$appointment->assigned_employee}}
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
            <div class="row mb-3">
                <div class="col d-flex justify-content-end align-items-center ">
                    <form action="{{ route('appointments.complete', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this request?');">
                        @csrf
                        <button type="submit" class="btn color2 btn-dark">Complete</button>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
@endsection