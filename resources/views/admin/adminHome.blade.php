@extends('layouts.admin')

@section('styles')
<style>
    
</style>
@endsection

@section('content')
    <div class="row h-100 w-100 align-items-center">
        <div class="col">
            <div class="row">
                <div class="col textstyle3" style="font-size: 1.2rem;">
                    Dashboard
                </div>
                <hr>
            </div>
            <div class="row mb-3 gap-3 ">
                <a href="{{route('upcomingAppt')}}" class="col px-4 pt-3 pb-3 color2 containerShadow2 text-decoration-none hover-effect2 position-relative">
                    <div class="row d-flex align-items-center">
                        <div class="col-8">
                            <div class="row mb-3 textstyle5">
                                <div class="col" style="font-size: 1.5rem">
                                    {{$totalAppointments}}
                                </div>
                            </div>
                            <div class="row textstyle6">
                                <div class="col">
                                    Upcoming Appointments
                                </div>
                            </div>
                        </div>
                        <div class="col d-none d-lg-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-calendar textstyle5 font-size-icon"></i>
                        </div>
                    </div>
                    <i id="redDot" class="fa fa-circle text-danger position-absolute" style="top: 10px; right: 10px; font-size: 10px;"></i>
                </a>
                
                <a href="{{route('showPrescriptionPage')}}" class="col px-4 pt-3 pb-3 color2 containerShadow2 text-decoration-none hover-effect2 position-relative">
                    <div class="row d-flex align-items-center">
                        <div class="col-8">
                            <div class="row mb-3 textstyle5">
                                <div class="col" style="font-size: 1.5rem">
                                    {{$totalPrescriptions}}
                                </div>
                            </div>
                            <div class="row textstyle6">
                                <div class="col">
                                    Prescription Request
                                </div>
                            </div>
                        </div>
                        <div class="col d-none d-lg-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-capsules textstyle5 font-size-icon"></i>
                        </div>
                    </div>
                    <i id="prescriptionRedDot" class="fa fa-circle text-danger position-absolute" style="top: 10px; right: 10px; font-size: 10px;"></i>
                </a>
                
                <a href="{{route('patientInfo')}}" class="col px-4 pt-3 pb-3 color2  containerShadow2 text-decoration-none hover-effect2">
                    <div class="row  d-flex align-items-center">
                        <div class="col-8 ">
                            <div class="row mb-3 textstyle5">
                                <div class="col" style="font-size: 1.5rem">
                                    {{$totalPatients}}
                                </div>
                            </div>
                            <div class="row textstyle6">
                                <div class="col">
                                    Total Patients
                                </div>
                            </div>
                        </div>
                        <div class="col  d-none d-lg-flex justify-content-center align-items-center ">
                            <i class="fa-solid fa-users textstyle5 font-size-icon" style=""></i>
                        </div>
                    </div>
                </a>
                <a href="{{route('empInfo')}}" class="col px-4 pt-3 pb-3  color2 containerShadow2 text-decoration-none hover-effect2">
                    <div class="row d-flex align-items-center">
                        <div class="col-8 ">
                            <div class="row mb-3 textstyle5">
                                <div class="col" style="font-size: 1.5rem">
                                    {{$totalEmployees}}
                                </div>
                            </div>
                            <div class="row textstyle6">
                                <div class="col">
                                    Total Employees
                                </div>
                            </div>
                        </div>
                        <div class="col d-none d-lg-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-user-tie textstyle5 font-size-icon" style=""></i>
                        </div>
                    </div>
                </a>
                
            </div>
            
            <div class="row gap-3 mb-3">
                <div class="col-md-8 containerShadow2">
                    <div class="row color2">
                        <div class="col textstyle5 p-2">Patient Visit Trend Overtime</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <canvas id="appointmentChart" style="min-height: 64vh"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col containerShadow2 ">
                    <div class="row color2 p-2 textstyle5">
                        <div class="col">
                            Your Task
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="row textstyle5">
                                <div class="col p-0">
                                    <ul class="nav nav-tabs position-relative" id="taskTab" role="tablist">
                                        <li class="nav-item position-relative" role="presentation">
                                            <button class="nav-link active p-1" id="appointments-tab" style="font-size: 0.8rem" data-bs-toggle="tab" data-bs-target="#appointments" type="button" role="tab" aria-controls="appointments" aria-selected="true">
                                                Appointments
                                            </button>
                                            <i id="appointmentsRedDot" class="fa fa-circle text-danger position-absolute" style="top: 1px; right: -3px; font-size: 8px;"></i>
                                        </li>
                                        <li class="nav-item position-relative" role="presentation">
                                            <button class="nav-link p-1" id="care-delivery-tab" style="font-size: 0.8rem" data-bs-toggle="tab" data-bs-target="#care-delivery" type="button" role="tab" aria-controls="care-delivery" aria-selected="false">
                                                Care Deliveries
                                            </button>
                                            <i id="careDeliveryRedDot" class="fa fa-circle text-danger position-absolute" style="top: 1px; right: -3px; font-size: 8px;"></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row" style="overflow-x: hidden; overflow-y: auto; min-height:61vh; max-height:61vh;">
                                <div class="col">
                                    <div class="tab-content" id="taskTabContent">
                                        <div class="tab-pane fade show active" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
                                            @foreach ($appointmentTasks as $appointment)
                                                <a class="row p-2 hover-effect text-decoration-none">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col textstyle3">
                                                                {{$appointment->appointment_type}} with {{$appointment->patient->name}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col" style="font-size: 0.8rem">
                                                                {{$appointment->appointment_date}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col" style="font-size: 0.8rem">
                                                                {{ date('g:i A', strtotime($appointment->appointment_time)) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                        <div class="tab-pane fade" id="care-delivery" role="tabpanel" aria-labelledby="care-delivery-tab">
                                            @foreach ($careDeliveryTasks as $careDelivery)
                                                <a class="row p-2 hover-effect text-decoration-none">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col textstyle3">
                                                                {{$careDelivery->care_delivery_type}} with {{$careDelivery->patient->name}}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col" style="font-size: 0.8rem">
                                                                {{$careDelivery->date}}
                                                            </div>
                                                            <div class="col" style="font-size: 0.8rem">
                                                                {{ date('g:i A', strtotime($careDelivery->time)) }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col" style="font-size: 0.8rem">
                                                                {{$careDelivery->patient->address_line_1}} {{$careDelivery->patient->address_line_2}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
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

<script>
document.addEventListener('DOMContentLoaded', function() {

    const redDot = document.getElementById('redDot');
    const totalAppointments = parseInt(document.querySelector('.textstyle5 .col').innerText);
    
    if (totalAppointments > 0) {
        redDot.style.display = 'block';
    } else {
        redDot.style.display = 'none';
    }

 
    const prescriptionRedDot = document.getElementById('prescriptionRedDot');
    const totalPrescriptions = parseInt(document.querySelector('a[href="{{route('showPrescriptionPage')}}"] .textstyle5 .col').innerText);
    
    if (totalPrescriptions > 0) {
        prescriptionRedDot.style.display = 'block';
    } else {
        prescriptionRedDot.style.display = 'none';
    }

    const appointmentsRedDot = document.getElementById('appointmentsRedDot');
    const appointmentTasks = {{ count($appointmentTasks) }};
    
    if (appointmentTasks > 0) {
        appointmentsRedDot.style.display = 'block';
    } else {
        appointmentsRedDot.style.display = 'none';
    }

    // Red Dot for Care Deliveries Tab
    const careDeliveryRedDot = document.getElementById('careDeliveryRedDot');
    const careDeliveryTasks = {{ count($careDeliveryTasks) }};
    
    if (careDeliveryTasks > 0) {
        careDeliveryRedDot.style.display = 'block';
    } else {
        careDeliveryRedDot.style.display = 'none';
    }
});


</script>
@endsection