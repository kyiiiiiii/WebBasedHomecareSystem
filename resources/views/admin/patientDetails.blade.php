@extends('layouts.admin')


@section('content')

    <div class="row w-100 h-100">
        
        <div class="col-md-3 pt-5 p-4" style="border-right: 1px solid grey">
            <div class="row ">
                <div class="col d-flex justify-content-center">
                    <form id="patient-profile-form" action="{{ route('updatePatientPicture', ['id' => $patient->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <label for="patientFileUpload" class="upload-label2 d-flex align-items-center justify-content-center containerShadow2">
                            <img id="patientProfileImage" src="data:image/jpeg;base64,{{ base64_encode($patient->patient_image) }}" class="img-fluid" alt="Click to Upload Image">
                            <span class="upload-icon">
                                <i class="fa-solid fa-image"></i>
                            </span>
                            <span class="upload-text">Upload Image</span>
                        </label>
                        <input type="file" id="patientFileUpload" name="profile_image" accept="image/*" style="display:none;">
                    </form>  
                </div>
            </div>
            
            <div class="row">
                <div class="col px-2">
                    <div class="row p-2 justify-content-center mb-3 textstyle3">
                        {{$patient->name}}
                    </div>
                    <div class="row">
                        <div class="col-sm mb-2" style="background-color: white">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">PATIENT ID</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="id" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->id}}" readonly>
                            </div>
                        </div>
                    </div>                      
                    <div class="row">
                        <div class="col-sm mb-2" style="background-color: white">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">GENDER</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="role" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->gender}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm mb-2" style="background-color: white">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">AGE</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="department" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->age}}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm mb-2" style="background-color: white">
                            <div class="row ps-1 pt-1">
                                <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">DATE OF BIRTH</div>
                            </div>
                            <div class="row px-1 pb-2">
                                <input type="text" name="admission_date" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->date_of_birth}}" readonly>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
        <div class="col">
           
            <form action="{{route('updatePatientData',['id' => $patient->id])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-1" >
                    <div class="col">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Patient Information</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Medical history</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">Appointments</button>
                            </li>
                        </ul>
                        <div class="tab-content p-2 white" id="myTabContent" style="overflow-x: hidden; overflow-y: auto; max-height: 50vh; min-height: 50vh">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" style="overflow-x: hidden; overflow-y: auto; max-height: 50vh; min-height: 50vh">
                                <div class="col">
                                    <div class="row ps-2">
                                        <div class="col textstyle3 d-flex align-items-center">
                                            Personal Details
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col mb-2 d-flex justify-content-end">
                                                    <div id="edit-btn" class="btn btn-secondary">Edit</div>
                                                    <button type="submit" id="save-btn" class="btn btn-dark color3" style="display:none;">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    @if(session("update_patient_success"))
                                            <div class="alert alert-success">
                                                {{ session('update_patient_success') }}
                                            </div>
                                        @endif
                                        @if(session("access_denied"))
                                            <div class="alert alert-danger">
                                                {{ session('access_denied') }}
                                            </div>
                                        @endif
                                        @if(session("error"))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                    <div class="row ps-2 mb-3">
                                        <div class="col-md-2 col-auto" >
                                            <div class="row">
                                                <div class="col" style="color: gray; font-size: 0.8rem;">
                                                    FIRST NAME
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col ">
                                                    <input type="text" name="first_name" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->first_name}}" readonly>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col" style="font-size: 0.8rem;color: gray">
                                                    LAST NAME
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col">
                                                    <input type="text" name="last_name" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->last_name}}" readonly>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    
                                    <div class="row ps-2 mb-3">
                                        <div class="col-md-2 col-auto">
                                            <div class="row">
                                                <div class="col" style="font-size: 0.8rem;color: gray">
                                                    ADDRESS LINE 1
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col">
                                                    <input type="text" name="address_line_1" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->address_line_1}}" readonly>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-md-2 col-auto">
                                            <div class="row">
                                                <div class="col" style="font-size: 0.8rem;color: gray">
                                                    ADDRESS LINE 2
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col">
                                                    <input type="text" name="address_line_2" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->address_line_2}}" readonly>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
        
                                    <div class="row ps-2 mb-3">
                                        <div class="col-md-2 col-auto">
                                            <div class="row">
                                                <div class="col" style="font-size: 0.8rem;color: gray">
                                                    CITY 
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col">
                                                    <input type="text" name="city" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->city}}" readonly>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-md-2 col-auto">
                                            <div class="row">
                                                <div class="col" style="font-size: 0.8rem;color: gray">
                                                    STATE 
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col">
                                                    <input type="text" name="state" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->state}}" readonly>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col" style="font-size: 0.8rem;color: gray">
                                                    POSTAL CODE 
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col">
                                                    <input type="text" name="postal_code" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->postal_code}}" readonly>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
        
                                    <div class="row ps-2">
                                        <div class="col textstyle3">
                                            Emergency Contact Information
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row ps-2 mb-3">
                                        <div class="col-md-3 col-auto" >
                                            <div class="row">
                                                <div class="col" style="font-size: 0.8rem;color: gray">
                                                    EMERGENCY CONTACT
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col">
                                                    <input type="text" name="emergency_contact_name" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->emergency_contact_name}}" readonly>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col" style="font-size: 0.8rem;color: gray">
                                                    RELATIONSHIP
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col">
                                                    <input type="text" name="emergency_relationship" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->emergency_relationship}}" readonly>
                                                    
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row ps-2 mb-3">
                                        <div class="col-md-3 col-auto">
                                            <div class="row">
                                                <div class="col" style="font-size: 0.8rem;color: gray">
                                                    EMERGENCY CONTACT
                                                </div>
                                            </div>
                                            <div class="row textstyle3">
                                                <div class="col">
                                                    <input type="text" name="emergency_contact" class="col d-flex align-items-center customProfileInput textstyle3" value="{{$patient->emergency_contact}}" readonly>
                                                    
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab" style="overflow-x: hidden; overflow-y: auto; max-height: 50vh; min-height: 50vh" >
                                <div class="col">
                                    <div class="row p-2">
                                        <div class="col textstyle3">
                                            Medical Information
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row ps-2 mb-3">
                                        <div class="col-md-3 col-auto  align-items-center">
                                            <div class="row">
                                                <div class="col" style="color: gray">
                                                    Medical History 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col align-items-center">
                                            <div class="row">
                                                <div class="col" style="color: gray">
                                                    <a href="{{route('MedicalHistory', $patient->id)}}" class="btn btn-primary mb-3">Download Medical History</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row ps-2 mb-3">
                                        <div class="col">
                                            <form action="{{ route('updateMedicalHistory', $patient->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-3" style="color: gray">Upload New Medical History</div>
                                                    <div class="col"><input type="file" name="medical_history_file" id="medical_history_file" class="form-control"></div>
                                                    <div class="col"><button type="submit" class="btn btn-primary mb-3">Update Medical History</button></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row p-2">
                                        <div class="col textstyle3">
                                            Allergies
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row ps-2 mb-3">
                                    <div class="col">
                                        Alcohol
                                    </div>
                                    </div>
        
                                    <div class="row p-2">
                                        <div class="col textstyle3">
                                            Drug Used
                                        </div>
                                        <hr>
                                    </div>
        
                                    <div class="row ps-2 mb-3">
                                        <div class="col">
                                            Antipyretics
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                            <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab" style="overflow-x: hidden; overflow-y: auto;max-height: 50vh; min-height: 50vh">
                                <div class="col">
                                    <div class="row ps-2 ">
                                        <div class="col textstyle3">
                                            Upcoming Appointments
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row ps-2 mb-3" style="background-color:rgb(240, 240, 250); overflow-x: hidden; overflow-y: auto; max-height:20vh">
                                        <div class="col">
                                            <div class="row p-2 color2 textstyle5 align-items-center text-center">
                                                <div class="col">Appointment Date</div>
                                                <div class="col">Appointment Time</div>
                                                <div class="col">Appointment Type</div>
                                            </div>
                                            @foreach ($upcomingAppointments as $appointment)
                                            <div class="row hover-effect p-2 align-items-center text-center" style="border-bottom: 1px solid lightgrey">
                                                <div class="col">{{$appointment->appointment_date}}</div>
                                                <div class="col">{{$appointment->appointment_time}}</div>
                                                <div class="col">{{$appointment->appointment_type}}</div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
        
                                    <div class="row p-2">
                                        <div class="col textstyle3">
                                            History
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="row ps-2 mb-3">
                                        <div class="col">
                                            <div class="row p-2 color2 textstyle5 align-items-center text-center">
                                                <div class="col">Appointment Date</div>
                                                <div class="col">Appointment Type</div>
                                                <div class="col">Appointment Status</div>
                                            </div>
                                            @foreach ($passedAppointments as $appointment)
                                            <div class="row hover-effect p-2 align-items-center text-center" style="border-bottom: 1px solid lightgrey">
                                                <div class="col">{{$appointment->appointment_date}}</div>
                                                <div class="col">{{$appointment->appointment_type}}</div>
                                                <div class="col">{{$appointment->status}}
                                                    @if($appointment->status == 'completed')
                                                        <i class="mx-1 fa-solid fa-check-double" style="color: rgb(31, 246, 31)"></i>
                                                    @elseif($appointment->status == 'passed')
                                                        <i class="mx-1 fa-solid fa-times" style="color: red;"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col" >
                        <div class="row">
                            <div class="col ">
                                <div class="mb-1 d-flex justify-content-end">
                                    <select id="chartSelect">
                                        <option value="patientActivityChart">Patient Activity Chart</option>
                                        <option value="bpmChart">BPM Chart</option>
                                    </select>
                                </div>
                                
                                <canvas id="patientActivityChart" style="max-height: 36vh" class="white" data-patient-id="{{ $patient->id }}"></canvas>
                                
                                <div id="bpmChartContainer" class="d-none" data-patient-id="{{ $patient->id }}">
                                    <div id="bpm-result">Latest BPM: </div>
                                    <canvas id="bpmChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


<div class="modal fade" id="patientCropImageModal" tabindex="-1" role="dialog" aria-labelledby="patientCropImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientCropImageModalLabel">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="image" src="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="cropButton">Crop</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/smoothie@1.36.0/smoothie.js"></script>
<script>
    var patientId = {{ $patient->id }};
    const bpmResultElement = document.getElementById('bpm-result');
    const bpmChartCanvas = document.getElementById('bpmChart');
    const bpmChartContainer = document.getElementById('bpmChartContainer');
    const patientActivityChart = document.getElementById('patientActivityChart');
    const chartSelect = document.getElementById('chartSelect');

    // Dynamically resize the canvas
    function resizeCanvas() {
        bpmChartCanvas.width = bpmChartCanvas.parentElement.clientWidth;
        bpmChartCanvas.height = 200;  // Adjust height if needed
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();  // Initial resize

    // Initialize Smoothie Chart with custom background and line spacing
    const smoothie = new SmoothieChart({
        grid: {
            strokeStyle: 'rgba(0, 0, 0, 0.1)',  // Light grid lines
            fillStyle: 'rgba(57, 255, 20, 0.2)',  // Background color (light blue with transparency)
            lineWidth: 1,
            millisPerLine: 1000,  // Grid lines appear every second
            verticalSections: 10
        },
        labels: { fillStyle: 'rgb(0, 0, 0)' },
        maxValue: 800,
        minValue: 0,
        millisPerPixel: 100  // Slower scrolling, less compact lines
    });

    // Stream the chart to the canvas
    smoothie.streamTo(bpmChartCanvas, 1000);

    // Create the TimeSeries object for BPM data
    const bpmSeries = new TimeSeries();

    // Add the time series to the chart with a red line
    smoothie.addTimeSeries(bpmSeries, { strokeStyle: 'rgb(255, 0, 0)', lineWidth: 2 });

    // Initialize Pusher
    var pusher = new Pusher('3b6b01805bb66418b849', {
        cluster: 'ap1',
        forceTLS: false
    });

    var channel = pusher.subscribe('bpm-channel');
    channel.bind('App\\Events\\PatientBpmUpdated', function(data) {
        console.log('BPM Update received: ', data);
    
    // Check if the patient ID matches
        if (data.patient_id == patientId) {
            let bpmValue = parseInt(data.bpm_value);

            // Append the BPM data to the time series
            bpmSeries.append(new Date().getTime(), bpmValue);

            // Update the result in the view
            bpmResultElement.innerText = bpmValue ;
        } else {
            console.log('Received BPM update for a different patient.');
        }
    });

    // Ensure canvas is resized during each frame render
    setInterval(function() {
        resizeCanvas();  // Adjust the canvas width dynamically as the container size changes
    }, 1000);

    // Show/hide the correct chart based on dropdown selection
    chartSelect.addEventListener('change', function() {
        const selectedChart = chartSelect.value;

        if (selectedChart === 'bpmChart') {
            // Hide patient activity chart, show BPM chart
            patientActivityChart.classList.add('d-none');
            bpmChartContainer.classList.remove('d-none');
        } else {
            // Hide BPM chart, show patient activity chart
            bpmChartContainer.classList.add('d-none');
            patientActivityChart.classList.remove('d-none');
        }
    });
</script>
<script>
    document.getElementById("edit-btn").addEventListener("click", function() {
        // Get all input fields with the class 'customProfileInput'
        var inputs = document.querySelectorAll(".customProfileInput");

        // Enable editing for all input fields
        inputs.forEach(function(input) {
            input.removeAttribute("readonly");
            input.style.border = "1px solid #ccc"; // Apply border to indicate it's editable
        });

        // Show the 'Save Changes' button and hide the 'Edit' button
        document.getElementById("save-btn").style.display = "inline-block";
        document.getElementById("edit-btn").style.display = "none";
    });

    document.getElementById("save-btn").addEventListener("click", function() {
        // Get all input fields with the class 'customProfileInput'
        var inputs = document.querySelectorAll(".customProfileInput");

        // Disable editing for all input fields
        inputs.forEach(function(input) {
            input.setAttribute("readonly", true);
            input.style.border = "none"; // Remove border to indicate it's readonly
        });

        // Hide the 'Save Changes' button and show the 'Edit' button
        document.getElementById("save-btn").style.display = "none";
        document.getElementById("edit-btn").style.display = "inline-block";
    });
</script>
@endsection