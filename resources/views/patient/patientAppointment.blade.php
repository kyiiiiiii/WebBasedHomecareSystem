@extends('layouts.patient')


@section('content')
<div class="h-100 w-100 align-items-center">
    <div class="row">
        <div class="col">
            <h1>Activities</h1>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col">
            <ul class="nav nav-tabs" id="mainTab" role="tablist">
                <li class="nav-item" class="col" role="presentation">
                    <button class="col nav-link active" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#appointments" type="button" role="tab" aria-controls="appointments" aria-selected="true">Appointments</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="prescriptions-tab" data-bs-toggle="tab" data-bs-target="#prescriptions" type="button" role="tab" aria-controls="prescriptions" aria-selected="false">Prescriptions</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="care-delivery-tab" data-bs-toggle="tab" data-bs-target="#care-delivery" type="button" role="tab" aria-controls="care-delivery" aria-selected="false">Care Delivery</button>
                </li>
            </ul>

            <div class="tab-content containerShadow4 p-0 white" id="mainTabContent" style="overflow-x: hidden; overflow-y: auto; min-height:80vh; max-height: 80vh;">
                <!-- Appointments Tab with Nested Tabs -->
                <div class="tab-pane fade show active" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
                    <ul class="nav nav-pills my-3 justify-content-center" id="appointmentsNestedTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upcoming-appointments-tab" data-bs-toggle="tab" data-bs-target="#upcoming-appointments" type="button" role="tab" aria-controls="upcoming-appointments" aria-selected="true">Upcoming</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pending-appointments-tab" data-bs-toggle="tab" data-bs-target="#pending-appointments" type="button" role="tab" aria-controls="pending-appointments" aria-selected="false">Pending</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="past-appointments-tab" data-bs-toggle="tab" data-bs-target="#past-appointments" type="button" role="tab" aria-controls="past-appointments" aria-selected="false">Past</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="appointmentsNestedTabContent">
                        <!-- Upcoming Appointments -->
                        <div class="tab-pane fade show active" id="upcoming-appointments" role="tabpanel" aria-labelledby="upcoming-appointments-tab">
                            <div class="col px-5">
                                    @if($approvedAppointments->isEmpty())
                                    <div class="row">
                                        <div class="col p-2 d-flex justify-content-center align-items-center">
                                            --No Upcoming Appointments--
                                        </div>
                                    </div>
                                @else
                                @foreach($approvedAppointments as $approvedAppointment)
                                <div class="col mb-3 custom-container2 containerShadow1 p-2 white " style="border-left: 5px solid rgb(23, 80, 238); ">
                                        <a href="{{route('showPatientAppointmentDetails',$approvedAppointment->id)}}" class="row text-decoration-none" style="color: black">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col d-flex align-items-center" style="font-weight: bold; font-size:1rem">
                                                        Appointment type : {{$approvedAppointment->appointment_type}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col d-flex align-items-center" style="font-size:0.8rem">
                                                        Status : {{$approvedAppointment->status}}<i class="fa-solid fa-check p-1" style="color: green"></i>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 d-flex align-items-center" style="font-size:0.8rem;">
                                                        Appointment date : {{$approvedAppointment->appointment_date}}
                                                    </div>
                                                    <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                        Appointment time : {{$approvedAppointment->appointment_time}}
                                                    </div>
                                                    <hr>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                        @if ($approvedAppointment->employee->profile_image)
                                                            <img src="data:image/jpeg;base64,{{ base64_encode($approvedAppointment->employee->profile_image) }}" width="30" height="30" class="rounded-circle me-2" alt="Profile Image">
                                                        @else
                                                            <span class="no-image">No image</span>
                                                        @endif
                                                        Healthcare Assigned : {{$approvedAppointment->employee->name}}
                                                    </div>
                                                </div>
                                            </div>

                                        </a>
                                    
                                    </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Pending Appointments -->
                        <div class="tab-pane fade" id="pending-appointments" role="tabpanel" aria-labelledby="pending-appointments-tab">
                            <div class="col px-5">
                                @if($pendingAppointments->isEmpty())
                                    <div class="row">
                                        <div class="col p-2 d-flex justify-content-center align-items-center">
                                            --No Pending Appointments--
                                        </div>
                                    </div>
                                @else
                                @foreach($pendingAppointments as $pendingAppointment)
                                <div class="col mb-3 custom-container2 containerShadow5 p-2 white" style="border-left: 5px solid grey">
                                    <a href="{{route('showPatientAppointmentDetails',$pendingAppointment->id)}}" class="row text-decoration-none" style="color: black">
                                        <div class="col">
                                            <div class="row ">
                                                <div class="col d-flex align-items-center" style="font-weight: bold; font-size:1rem">
                                                    Appointment type : {{$pendingAppointment->appointment_type}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem">
                                                    Status : {{$pendingAppointment->status}}<i class="fa-regular fa-clock p-1 " style="color: rgb(17, 92, 231)"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 d-flex align-items-center" style="font-size:0.8rem;">
                                                    Appointment date : {{$pendingAppointment->appointment_date}}
                                                </div>
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Appointment time : {{$pendingAppointment->appointment_time}}
                                                </div>
                                                <hr>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Healthcare Assigned : {{$pendingAppointment->status}} 
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                           </div>
                        </div>

                        <!-- Past Appointments -->
                        <div class="tab-pane fade" id="past-appointments" role="tabpanel" aria-labelledby="past-appointments-tab">
                            <div class="col px-5">
                                @if($completedAppointments->isEmpty())
                                    <div class="row">
                                        <div class="col p-2 d-flex justify-content-center align-items-center">
                                            --No Completed Appointments--
                                        </div>
                                    </div>
                                @else
                                @foreach($completedAppointments as $completedAppointment)
                                <div class="col mb-3 custom-container2 containerShadow5 p-2 white" style="border-left: 5px solid green">
                                    <a href="{{route('showPatientAppointmentDetails',$completedAppointment->id)}}" class="row text-decoration-none" style="color: black">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-weight: bold; font-size:1rem">
                                                    Appointment type : {{$completedAppointment->appointment_type}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem">
                                                    Status : {{$completedAppointment->status}}<i class="fa-solid fa-check-double p-1" style="color: green"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 d-flex align-items-center" style="font-size:0.8rem;">
                                                    Appointment date : {{$completedAppointment->appointment_date}}
                                                </div>
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Appointment time : {{$completedAppointment->appointment_time}}
                                                </div>
                                                <hr>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    @if ($completedAppointment->employee->profile_image)
                                                        <img src="data:image/jpeg;base64,{{ base64_encode($completedAppointment->employee->profile_image) }}" width="30" height="30" class="rounded-circle me-2" alt="Profile Image">
                                                    @else
                                                        <span class="no-image">No image</span>
                                                    @endif
                                                    Healthcare Assigned : {{$completedAppointment->employee->name}}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                           </div>
                        </div>
                    </div>
                </div>

                <!-- Prescriptions Tab with Nested Tabs -->
                <div class="tab-pane fade" id="prescriptions" role="tabpanel" aria-labelledby="prescriptions-tab">
                    <ul class="nav nav-pills my-3 justify-content-center" id="prescriptionsNestedTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upcoming-prescriptions-tab" data-bs-toggle="tab" data-bs-target="#upcoming-prescriptions" type="button" role="tab" aria-controls="upcoming-prescriptions" aria-selected="true">Upcoming</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pending-prescriptions-tab" data-bs-toggle="tab" data-bs-target="#pending-prescriptions" type="button" role="tab" aria-controls="pending-prescriptions" aria-selected="false">Pending</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="past-prescriptions-tab" data-bs-toggle="tab" data-bs-target="#past-prescriptions" type="button" role="tab" aria-controls="past-prescriptions" aria-selected="false">Past</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="prescriptionsNestedTabContent">
                        <!-- Upcoming Prescriptions -->
                        <div class="tab-pane fade show active" id="upcoming-prescriptions" role="tabpanel" aria-labelledby="upcoming-prescriptions-tab">
                            <div class="col px-5">
                                @if($approvedPrescriptions->isEmpty())
                                    <div class="row">
                                        <div class="col p-2 d-flex justify-content-center align-items-center">
                                            --No Upcoming Prescriptions--
                                        </div>
                                    </div>
                                @else
                                @foreach($approvedPrescriptions as $approvedPrescription)
                                <div class="col mb-3 custom-container2 containerShadow5 p-2 white" style="border-left: 5px solid rgb(3, 26, 230)">
                                    <a href="{{route('showPrescriptionDetails',$approvedPrescription->id)}}" class="row text-decoration-none" style="color: black">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-weight: bold; font-size:1rem">
                                                    Prescription ID : {{$approvedPrescription->id}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem">
                                                    Status : {{$approvedPrescription->status}}<i class="fa-solid fa-check p-1" style="color: green"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 d-flex align-items-center" style="font-size:0.8rem;">
                                                    Appointment date : {{$approvedPrescription->prescription_date}}
                                                </div>
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Address : {{$approvedPrescription->patient->address_line_1}}
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                           </div>
                        </div>

                        <!-- Pending Prescriptions -->
                        <div class="tab-pane fade" id="pending-prescriptions" role="tabpanel" aria-labelledby="pending-prescriptions-tab">
                            <div class="col px-5">
                                @if($pendingPrescriptions->isEmpty())
                                    <div class="row">
                                        <div class="col p-2 d-flex justify-content-center align-items-center">
                                            --No Pending Prescriptions--
                                        </div>
                                    </div>
                                @else
                                @foreach($pendingPrescriptions as $pendingPrescription)
                                <div class="col mb-3 custom-container2 containerShadow5 p-2 white" style="border-left: 5px solid grey">
                                    <a href="{{route('showPrescriptionDetails',$pendingPrescription->id)}}" class="row text-decoration-none" style="color: black">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-weight: bold; font-size:1rem">
                                                    Prescription ID : {{$pendingPrescription->id}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem">
                                                    Status : {{$pendingPrescription->status}}<i class="fa-regular fa-clock p-1 " style="color: rgb(17, 92, 231)"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 d-flex align-items-center" style="font-size:0.8rem;">
                                                    Appointment date : {{$pendingPrescription->prescription_date}}
                                                </div>
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Address : {{$pendingPrescription->patient->address_line_1}}
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                           </div>
                        </div>

                        <!-- Past Prescriptions -->
                        <div class="tab-pane fade" id="past-prescriptions" role="tabpanel" aria-labelledby="past-prescriptions-tab">
                            <div class="col px-5">
                                @if($completedPrescriptions->isEmpty())
                                    <div class="row">
                                        <div class="col p-2 d-flex justify-content-center align-items-center">
                                            --No Past Prescriptions--
                                        </div>
                                    </div>
                                @else
                                @foreach($completedPrescriptions as $completedPrescription)
                                <div class="col mb-3 custom-container2 containerShadow5 p-2 white" style="border-left: 5px solid green">
                                    <a href="{{route('showPrescriptionDetails',$completedPrescription->id)}}" class="row text-decoration-none" style="color: black">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-weight: bold; font-size:1rem">
                                                    Prescription ID : {{$completedPrescription->id}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem">
                                                    Status : {{$completedPrescription->status}}<i class="fa-solid fa-check-double p-1" style="color: green"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 d-flex align-items-center" style="font-size:0.8rem;">
                                                    Appointment date : {{$completedPrescription->prescription_date}}
                                                </div>
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Address : {{$completedPrescription->patient->address_line_1}}
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                           </div>
                        </div>
                    </div>
                </div>

                <!-- Care Delivery Tab with Nested Tabs -->
                <div class="tab-pane fade" id="care-delivery" role="tabpanel" aria-labelledby="care-delivery-tab">
                    <ul class="nav nav-pills my-3 justify-content-center" id="careDeliveryNestedTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="upcoming-care-delivery-tab" data-bs-toggle="tab" data-bs-target="#upcoming-care-delivery" type="button" role="tab" aria-controls="upcoming-care-delivery" aria-selected="true">Upcoming</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pending-care-delivery-tab" data-bs-toggle="tab" data-bs-target="#pending-care-delivery" type="button" role="tab" aria-controls="pending-care-delivery" aria-selected="false">Pending</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="past-care-delivery-tab" data-bs-toggle="tab" data-bs-target="#past-care-delivery" type="button" role="tab" aria-controls="past-care-delivery" aria-selected="false">Past</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="careDeliveryNestedTabContent">
                        <!-- Upcoming Care Delivery -->
                        <div class="tab-pane fade show active" id="upcoming-care-delivery" role="tabpanel" aria-labelledby="upcoming-care-delivery-tab">
                            <div class="col px-5">
                                @if($approvedCaredeliveries->isEmpty())
                                    <div class="row">
                                        <div class="col p-2 d-flex justify-content-center align-items-center">
                                            --No Upcoming Care Delivery--
                                        </div>
                                    </div>
                                @else
                                @foreach($approvedCaredeliveries as $approvedCaredelivery)
                                <div class="col mb-3 custom-container2 containerShadow5 p-2 white" style="border-left: 5px solid rgb(2, 5, 219)">
                                    <a href="{{route('showPatientCareDeliveryDetails',$approvedCaredelivery->id)}}" class="row text-decoration-none" style="color: black">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-weight: bold; font-size:1rem">
                                                    Prescription ID : {{$approvedCaredelivery->id}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem">
                                                    Status : {{$approvedCaredelivery->status}}<i class="fa-solid fa-check p-1" style="color: green"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 d-flex align-items-center" style="font-size:0.8rem;">
                                                    Appointment date : {{$approvedCaredelivery->prescription_date}}
                                                </div>
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Address : {{$approvedCaredelivery->patient->address_line_1}}
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                           </div>
                        </div>

                        <!-- Pending Care Delivery -->
                        <div class="tab-pane fade" id="pending-care-delivery" role="tabpanel" aria-labelledby="pending-care-delivery-tab">
                            <div class="col px-5">
                                @if($pendingCaredeliveries->isEmpty())
                                    <div class="row">
                                        <div class="col p-2 d-flex justify-content-center align-items-center">
                                            --No Upcoming Care Delivery--
                                        </div>
                                    </div>
                                @else
                                @foreach($pendingCaredeliveries as $pendingCaredelivery)
                                <div class="col mb-3 custom-container2 containerShadow5 p-2 white" style="border-left: 5px solid grey">
                                    <a href="{{route('showPatientCareDeliveryDetails',$pendingCaredelivery->id)}}" class="row text-decoration-none" style="color: black">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-weight: bold; font-size:1rem">
                                                    Prescription ID : {{$pendingCaredelivery->id}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem">
                                                    Status : {{$pendingCaredelivery->status}}<i class="fa-solid fa-clock p-1" style="color: rgb(17, 5, 179)"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 d-flex align-items-center" style="font-size:0.8rem;">
                                                    Care Delivery date : {{$pendingCaredelivery->date}}
                                                </div>
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Care Delivery Time : {{$pendingCaredelivery->time}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Address : {{$pendingCaredelivery->patient->address_line_1}} {{$pendingCaredelivery->patient->address_line_2}}
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Healthcare Assigned : Pending
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                           </div>
                        </div>

                        <!-- Past Care Delivery -->
                        <div class="tab-pane fade" id="past-care-delivery" role="tabpanel" aria-labelledby="past-care-delivery-tab">
                            <div class="col px-5">
                                @if($completedCaredeliveries->isEmpty())
                                    <div class="row">
                                        <div class="col p-2 d-flex justify-content-center align-items-center">
                                            --No Completed Care Delivery History--
                                        </div>
                                    </div>
                                @else
                                @foreach($completedCaredeliveries as $completedCaredelivery)
                                <div class="col mb-3 custom-container2 containerShadow5 p-2 white" style="border-left: 5px solid green">
                                    <a href="{{route('showPatientCareDeliveryDetails',$completedCaredelivery->id)}}" class="row text-decoration-none" style="color: black">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-weight: bold; font-size:1rem">
                                                    Prescription ID : {{$completedCaredelivery->id}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem">
                                                    Status : {{$completedCaredelivery->status}}<i class="fa-solid fa-check-double p-1" style="color: green"></i>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 d-flex align-items-center" style="font-size:0.8rem;">
                                                    Care Delivery date : {{$completedCaredelivery->date}}
                                                </div>
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Care Delivery Time : {{$completedCaredelivery->time}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col d-flex align-items-center" style="font-size:0.8rem;">
                                                    Address : {{$completedCaredelivery->patient->address_line_1}} {{$completedCaredelivery->patient->address_line_2}}
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    @if ($completedAppointment->employee->profile_image)
                                                            <img src="data:image/jpeg;base64,{{ base64_encode($completedAppointment->employee->profile_image) }}" width="30" height="30" class="rounded-circle me-2" alt="Profile Image">
                                                    @else
                                                        <span class="no-image">No image</span>
                                                    @endif
                                                    Healthcare Assigned : {{$completedAppointment->employee->name}}

                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
