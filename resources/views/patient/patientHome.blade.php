@extends('layouts.patient')

@section('styles')
<style>
    
</style>
@endsection

@section('content')

<div class="row " style="width: 100%; height:100%;">
    <div class="row  d-flex align-items-center">
        <div class="col ms-1 p-0 " style="font-size: 1.8rem; font-weight:bold;">Dashboard</div>
        <div class="col-sm mb-3 mb-md-0 p-0 d-flex justify-content-start justify-content-md-end">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" >
                @if(($patient->patientAccount->profile_picture))
                    <img src="data:image/jpeg;base64,{{ base64_encode($patient->patientAccount->profile_picture) }}" alt="profile picture" width="30" height="30" class="rounded-circle">
                @endif
                <span class="mx-1  textstyle3">
                    @if(session('patientAccountName'))
                        {{ session('patientAccountName') }}
                    @endif
                </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="{{route("patientProfile")}}">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('patientLogout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign out
                    </a>
                    <form id="logout-form" action="{{ route('patientLogout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="col equal-height">
        <div class="row gap-3" style="flex: 1;">
            <div class="col-md-8  equal-height">
                <div class="row gap-3 content">
                    <div class="col">
                        <a href="{{ route('showAppointmentPatientForm') }}" class="row containerShadow2 mb-3 textstyle5 custom-container" style="font-size:1.2rem;">
                            <div class="col p-4">Make a new Appointment</div>
                            <div class="row">
                                <div class="col p-2 d-flex justify-content-end">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                        
                        <a href="{{ route('showPrescriptionForm') }}" class="row containerShadow2 mb-3 textstyle5 color1 custom-container" style="font-size:1.2rem;">
                            <div class="col p-4">Request For Prescription</div>
                            <div class="row">
                                 <div class="col p-2 d-flex justify-content-end">
                                     <i class="fa-solid fa-arrow-right"></i>
                                 </div>
                            </div>
                         </a>
                    </div>
                    <div class="col white containerShadow2 mb-3">
                        <div class="row textstyle5">
                            <div class="col-1 d-flex align-items-center color7">
                                <i class="fa-solid fa-list"></i>
                            </div>
                            <div class="col p-2 d-flex text-align-center color7">
                                Care Delivery Request
                            </div>
                            <hr>
                        </div>
                        
                        <div class="row" style="overflow-x: hidden; overflow-y: auto; max-height:23vh">
                            <div class="col">
                                @if($careDeliveries->isEmpty())
                                    <p class="text-center" style="color: gray">--You have no upcoming care delivery--</p>
                                @else
                                    @foreach($careDeliveries as $careDelivery)
                                        <a href="{{route('showPatientCareDeliveryDetails', $careDelivery->id)}}" class="text-decoration-none row hover-effect p-2">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col textstyle3">
                                                        {{$careDelivery->care_delivery_type}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col" style="font-size:0.8rem">
                                                        Status : {{$careDelivery->status}}<i class="fa-solid fa-check p-1" style="color: green"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col" style="font-size:0.8rem">
                                                        {{$careDelivery->date}}
                                                    </div>
                                                    <div class="col" style="font-size:0.8rem">
                                                        {{ date('g:i A', strtotime($careDelivery->time)) }}
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="row content">
                    <div class="col white containerShadow2 p-2">
                        <div id="patientCalendar" style="max-height: 55vh"></div>
                    </div>
                </div>
            </div>
        
            <div class="col  equal-height">
                <div class="row  mb-3 content" style="max-height: 60%">
                    <div class="col white containerShadow2">
                        <div class="row textstyle5">
                            <div class="col-1 col-auto d-flex align-items-center color7">
                                <i class="fa-regular fa-calendar-days"></i>
                            </div>
                            <div class="col p-2 d-flex align-items-center color7" style="font-weight:bold; font-size:1.0rem">
                                Next Appointment 
                            </div>
                            <hr>
                        </div>
                        
                        <div class="row mb-3" style="overflow-y: auto; min-height:40vh; max-height: 40vh;">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col">
                                        @if($patient->appointments->isEmpty())
                                            <p class="text-center" style="color: gray">--You have no upcoming appointments--</p>
                                        @else
                                        @foreach ($patient->appointments as $appointment)
                                            <a href="{{route('showPatientAppointmentDetails',$appointment->id)}}" class="row p-2 custom-container2 text-decoration-none" style="border-bottom: 0.5px solid lightgrey">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col textstyle3">
                                                            {{ $appointment->appointment_type }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col" style="font-size:0.8rem">
                                                            {{ $appointment->appointment_date }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col" style="font-size:0.8rem">
                                                            {{ date('g:i A', strtotime($appointment->appointment_time)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row  content" style="min-height: 40%; max-height: 40%;">
                    <div class="col white containerShadow2 ">
                        <div class="row textstyle5">
                            <div class="col-1 d-flex align-items-center color7">
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <div class="col p-2 d-flex text-align-center color7">
                                Activities 
                            </div>
                            <hr>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col" style="width: 50px;">
                                        <canvas id="patientActivityChart" class="h-100" data-patient-id="{{ $patient->id }}"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
