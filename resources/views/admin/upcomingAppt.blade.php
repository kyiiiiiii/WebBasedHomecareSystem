@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
    <div class="row containerShadow2 h-100 w-100" style="background-color: #e9ecef">
        <div class="col">
            <div class="row px-1 p-md-2 pb-md-0 mb-3 pt-2 mx-2">
                <div class="col">
                    <h1>Pending Appointments</h1>
                </div>
            </div>
            <hr>

            <div class="row p-1 p-md-2 mx-2">
                <div class="col d-flex align-items-center" style="background-color: white">
                    <i class="fas fa-magnifying-glass fa-1.5x me-2 icon-adjust"></i>
                    <input type="text" class="customContainer5" id="searchAppointments" placeholder="Search for Appointments">
                </div>
                <div class="col-2">
                    <button class="textstyle4 form-control" id="filterButton">Filter</button>
                </div>
            </div>
            

            @foreach($appointments as $date => $dateAppointments)
                <div class="row mx-2 text-bold" style="font-size:1.2rem">
                    <div class="col">
                        {{ $date }}
                    </div>
                </div>
                @foreach($dateAppointments as $appointment)
                    <div class="row p-1 p-md-2 mx-3 mb-3 containerShadow2 appointment-item" style="background-color: white">
                        <div class="col mb-3 mb-md-0">
                            <div class="row">
                                <div class="col" style="font-size:1.2rem;">Appointment Type: {{ $appointment->appointment_type }}</div>
                            </div>
                            <div class="row">
                                <div class="col" style="font-size:0.8rem">
                                    Requested by: {{ $appointment->patient->name }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="font-size:0.8rem">Appointment Date: {{ $appointment->appointment_date }}</div>
                            </div>
                            <div class="row">
                                <div class="col" style="font-size:0.8rem">
                                    @php
                                        $formattedTime = date('g:i A', strtotime($appointment->appointment_time));
                                    @endphp
                                    Appointment Time: {{ $formattedTime }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="font-size:0.8rem">Assigned Caregiver: <span id="caregiver-name-{{ $appointment->id }}">{{ $appointment->assigned_employee ? $appointment->assigned_employee->name : 'Unassigned' }}</span></div>
                            </div>
                            <div class="row">
                                <div class="col" style="font-size:0.8rem">Notes: {{ $appointment->notes }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md d-flex justify-content-start justify-content-md-end align-items-center mb-md-0 mb-2">
                            <div class="btn-group">
                                <button class="btn btn-primary assign-caregiver-btn" data-appointment-id="{{ $appointment->id }}" data-bs-toggle="modal" data-bs-target="#assignCaregiverModal">Assign Caregiver</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="actionsDropdown{{ $appointment->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu dropdown-menu-start" aria-labelledby="actionsDropdown{{ $appointment->id }}">
                                    <a class="dropdown-item customContainer4 approve-appointment" href="#" data-id="{{ $appointment->id }}">Approve</a>
                                    <div class="dropdown-divider"></div>
                                    
                                    <form action="{{ route('deleteAppointment', $appointment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</button>
                                    </form>
                                </div>
                                
                            </div>
                        </div>  
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <div class="modal fade textstyle3" id="assignCaregiverModal" tabindex="-1" aria-labelledby="assignCaregiverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignCaregiverModalLabel">Assign Caregiver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="assignCaregiverForm">
                        <input type="hidden" id="appointmentId">
                        <div class="mb-3">
                            <label for="caregiverSelect" class="form-label">Select Caregiver</label>
                            <select class="form-select" id="caregiverSelect" required>
                                <option value="">Choose...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary d-flex justify-content-end">Assign</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Handle assigning caregiver
            $('#assignCaregiverModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var appointmentId = button.data('appointment-id');
                $('#appointmentId').val(appointmentId);
            });

            $('#assignCaregiverForm').on('submit', function(event) {
                event.preventDefault();
                var caregiverId = $('#caregiverSelect').val();
                var appointmentId = $('#appointmentId').val();
                if (caregiverId) {
                    // Assign caregiver via AJAX
                    fetch(`/appointments/${appointmentId}/assignCaregiver`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ caregiver_id: caregiverId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            $('#caregiver-name-' + appointmentId).text(data.caregiver_name);
                            $('#assignCaregiverModal').modal('hide');
                        } else {
                            alert('This action require permission.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while assigning caregiver.');
                    });
                }
            });

            
            document.querySelectorAll('.approve-appointment').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var appointmentId = this.getAttribute('data-id');
                    var caregiverName = $('#caregiver-name-' + appointmentId).text();
                    if (caregiverName === 'Unassigned') {
                        alert('Please assign a caregiver before approving.');
                        return;
                    }
                    var caregiverId = $('#caregiverSelect').val();
                    fetch(`/appointments/${appointmentId}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ caregiver_id: caregiverId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Reload the page to reflect the changes
                        } else {
                            alert('Failed to approve the appointment.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while approving the appointment.');
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Handle input change
            $('#searchAppointments').on('keyup', function() {
                var keyword = $(this).val().toLowerCase();
    
                // Loop through each appointment item and filter
                $('.appointment-item').each(function() {
                    var appointmentText = $(this).text().toLowerCase();
    
                    if (appointmentText.includes(keyword)) {
                        $(this).show();  // Show if the keyword matches
                    } else {
                        $(this).hide();  // Hide if it doesn't match
                    }
                });
            });
        });
    </script>
    
@endsection
