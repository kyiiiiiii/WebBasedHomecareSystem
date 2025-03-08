@extends('layouts.patient')

@section('content')
<div class="row w-100 h-100">
    <div class="col">
        <div class="row p-5">
            <div class="col">
                @if($caregiver->caregiverProfile)
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="caregiverTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="details-tab" data-bs-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">Caregiver Details</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content white p-3" id="caregiverTabContent" style="min-height: 70vh; max-height:70vh overflow-x: hidden; overflow-y: auto;">
                        <!-- Caregiver Details Tab -->
                        <div class="tab-pane fade show active " id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="row mb-3 mt-3">
                                <div class="col">
                                    <img class="img-fluid" src="data:image/jpeg;base64,{{ base64_encode($caregiver->profile_image) }}" alt="Profile Image">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <strong>Name: </strong>Dr. {{ $caregiver->name }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <strong>Position: </strong> {{ $caregiver->role }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <strong>Years of Experience:</strong> {{ $caregiver->caregiverProfile->years_of_experience }} years
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <strong>Specializations:</strong> {{ $caregiver->caregiverProfile->specializations }}
                                </div>
                                <div class="col">
                                    <a href="https://www.linkedin.com/feed/" target="">LinkedIn Profile</a>
                                </div>
                                
                            </div>
                            <hr>
                            <div class="row mb-3">
                                <div class="col">
                                    <strong>Contact:</strong> {{ $caregiver->contact_number }}
                                </div>
                                
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <strong>Department:</strong> {{ $caregiver->department }}
                                </div>
                                <div class="col">
                                    <strong>Email:</strong> {{ $caregiver->email }} 
                                </div>
                                
                            </div>
                        </div>

                        <!-- History Tab -->
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                            <div class="row mb-3 mt-3 px-3">
                                <div class="col">
                                    <strong>History of Care:</strong>
                                    <hr>
                                    @if($sortedHistory->isNotEmpty())
                                        <div class="row font-weight-bold color2 textstyle5 p-2">
                                            <div class="col">
                                                Date
                                            </div>
                                            <div class="col">
                                                Type
                                            </div>
                                        </div>
                                        @foreach ($sortedHistory as $history)
                                            <div class="row p-2 hover-effect" style="border-bottom:1px solid rgb(233, 229, 229);">
                                                <div class="col">
                                                    {{ $history->date ?? $history->appointment_date ?? '--' }}
                                                </div>
                                                <div class="col">
                                                    @if(isset($history->appointment_type))
                                                        Appointment - {{ $history->appointment_type }}
                                                    @elseif(isset($history->care_delivery_type))
                                                        Care Delivery - {{ $history->care_delivery_type }}
                                                    @endif
                                                </div>
                                                
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No history available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                    </div>
                   
                    
                @else
                    <p>No additional caregiver profile information available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
