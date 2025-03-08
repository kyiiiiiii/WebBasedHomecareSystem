@extends('layouts.admin')

@section('styles')
    
@endsection

@section('content')
<div class="row w-100 h-100">
    <div class="col">
        <div class="row color2 containerShadow2 p-4 textstyle mb-3 mx-1">
            <h1 class="col-12 col-md" style="font-size: 2rem">
                Appointments Management
            </h1>
            <div class="col-12 col-md d-flex justify-content-start justify-content-md-end align-items-center">
                <a href="{{ route('showAppointmentForm') }}" class="btn btn-outline-light textstyle"><i class="fa-regular fa-plus me-2"></i> Add Appointment</a>
            </div>
        </div>
        
        <div class="row mb-3 mx-1 gap-3">
            <a href="upcomingAppt" class="col-md-3 textstyle3 containerShadow2 p-5 hover-effect">
                <div class="row align-items-center justify-content-center text-center">
                    <div class="col text-decoration-none">
                        <div class="label pb-lg-4">Pending Appointments</div>
                        <i class="fa-solid fa-user d-none d-md-block" style="font-size: 2.0rem; color:#1d3557;"></i>
                        <div class="value" style="font-size: 2rem; color:rgb(13, 116, 201)">{{$pendingAppointment}}</div>
                    </div>
                </div>
            </a>
            <div class="col-md containerShadow2 hover-effect">
                <div class="row color2 textstyle5 p-1">
                    <div class="col d-flex align-items-center justify-content-center">
                        Statistic
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="p-1" style="position: relative; max-height: 200px;">
                            <canvas id="myDoughnutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-md p-0 mt-sm-0 containerShadow2 hover-effect" id="list" style="max-height:250px">  
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="mb-3 containerShadow2 p-2" id="calendar"></div>
            </div>
        </div>
        @if(session('delete_appointment_success'))
            <div class="alert alert-success">
                {{ session('delete_appointment_success') }}
            </div>
        @elseif(session('delete_appointment_error'))
            <div class="alert alert-danger">
                {{ session('delete_appointment_error') }}
            </div>
        @endif
        <div class="row containerShadow2">
            <div class="col">
                <div class="row color2 textstyle p-2 align-items-center borderstyle">
                    <div class="col">Appointment ID</div>
                    <div class="col">Type of Appointment</div>
                    <div class="col">Date</div>
                    <div class="col">Days left</div>
                    <div class="col-1"></div>
                    <div class="col-1"></div>
                </div>
                @foreach($appointments as $appointment)
                <div class="p-2 row justify-content-center align-items-center textstyle4">
                    <div class="col">{{$appointment->id}}</div>
                    <div class="col">{{$appointment->appointment_type}}</div>
                    <div class="col">{{$appointment->appointment_date}}</div>
                    <div class="col">
                        @php
                            $today = \Carbon\Carbon::today();
                            $appointmentDate = \Carbon\Carbon::parse($appointment->appointment_date);
                            $daysLeft = $today->diffInDays($appointmentDate);
                            $isPassed = $today->gt($appointmentDate); 
                            $statusText = $isPassed ? 'Passed' : ($daysLeft . ' days left');
                        @endphp
                        {{ $statusText }}
                    </div>
                    <a href="{{route("apptDetails", $appointment->id)}}" class="col-1 btn btn-dark textstyle color3 ">View</a>
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $appointment->id }}">
                            <i class="fa-solid fa-trash-can text-danger" style="font-size: 1.5rem"></i>
                        </button>
                    </div>
                </div>
                <hr>

                <div class="modal fade" id="confirmDeleteModal-{{ $appointment->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col d-flex justify-content-center mb-3">
                                        <i class="fa-solid fa-exclamation text-danger" style="font-size: 3rem;"></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-center text-center" style="font-size: 1.2rem;">
                                        Do you want to delete this Appointment record? The process cannot be undone.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('deleteAppointment', $appointment->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="row p-2">
                    @if ($appointments->total() > 10)
                        <ul class="col pagination justify-content-center">
                            @if ($appointments->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-disabled="true">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $appointments->previousPageUrl() }}" aria-label="Previous">&laquo;</a>
                                </li>
                            @endif
                            @for ($i = 1; $i <= $appointments->lastPage(); $i++)
                                <li class="page-item {{ ($appointments->currentPage() == $i) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $appointments->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            @if ($appointments->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $appointments->nextPageUrl() }}" aria-label="Next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-disabled="true">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-center align-items-center">
                        Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} results
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
