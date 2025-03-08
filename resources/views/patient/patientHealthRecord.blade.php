@extends('layouts.patient')

@section('styles')
@endsection

@section('content')
<div class="row w-100 h-100">
    <div class="col-md-3 pt-5 p-4" style="border-right: 1px solid grey">
        <div class="row">
            <div class="col d-flex justify-content-center">
                <form id="patient-profile-form" action="{{ route('updatePatientPicture', ['id' => $patient->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label for="patientFileUpload" class="upload-label2 white d-flex align-items-center justify-content-center containerShadow2">
                        <img id="patientProfileImage" src="data:image/jpeg;base64,{{ base64_encode($patient->patient_image) }}" class="img-fluid" alt="No Image, click to upload">
                        <span class="upload-icon"><i class="fa-solid fa-image"></i></span>
                        <span class="upload-text">Upload Image</span>
                    </label>
                    <input type="file" id="patientFileUpload" name="profile_image" accept="image/*" style="display:none;">
                </form>
            </div>
        </div>
        <!-- Patient Information Section -->
        <div class="row">
            <div class="col px-2">
                <div class="row p-2 justify-content-center mb-3 textstyle3">{{ $patient->name }}</div>

                <div class="row">
                    <div class="col-sm mb-2" style="background-color: white">
                        <div class="row ps-1 pt-1">
                            <div class="col d-flex align-items-center textstyle7" style="font-size: 0.8rem;">PATIENT ID</div>
                        </div>
                        <div class="row px-1 pb-2">
                            <input type="text" name="id" class="col d-flex align-items-center customProfileInput textstyle3" value="{{ $patient->id }}" readonly>
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
        <div class="row mb-3">
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
                
                <!-- Tab Content -->
                <div class="tab-content p-2 white" id="myTabContent" style="overflow-x: hidden; overflow-y: auto; max-height: 50vh; min-height: 50vh">
                    <!-- Patient Information Tab -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab" >
                            <div class="col" >
                                <div class="row ps-2">
                                    <div class="col textstyle3">
                                        Personal Details
                                    </div>
                                    <hr>
                                </div>
                                <div class="row ps-2 mb-3">
                                    <div class="col-md-2 col-auto" >
                                        <div class="row">
                                            <div class="col" style="color: gray; font-size: 0.8rem;">
                                                FIRST NAME
                                            </div>
                                        </div>
                                        <div class="row textstyle3">
                                            <div class="col ">
                                                {{$patient->first_name}}
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
                                                {{$patient->last_name}}
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
                                                {{$patient->address_line_1}}
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
                                                {{$patient->address_line_2}}
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
                                                {{$patient->city}}
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
                                                {{$patient->state}}
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
                                                {{$patient->postal_code}}
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
                                                {{$patient->emergency_contact_name}}
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
                                                {{$patient->emergency_relationship}}
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
                                                {{$patient->emergency_contact}}
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>

                    <!-- Medical History Tab -->
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="col">
                            @if ($errors->has('medical_history_file'))
                                <div class="alert alert-danger">{{ $errors->first('medical_history_file') }}</div>
                            @endif
                            @if(session("medical_history_error"))
                                <div class="alert alert-danger">
                                    {{ session('medical_history_error') }}
                                </div>
                            @endif
                            @if(session("medical_history_success"))
                                <div class="alert alert-success">
                                    {{ session('medical_history_success') }}
                                </div>
                            @endif
                            
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
                                            <a href="{{route('patientMedicalHistory', $patient->id)}}" class="btn btn-primary mb-3">Download Medical History</a>
                                        </div>
                                    </div>
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

                    <!-- Appointments Tab -->
                    <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
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
                <div class="row mt-3">
                    <div class="col" >
                        <div class="row "style="width: 98%; height: 30vh;">
                            <div class="col ">
                                <div id="bpm-result">Latest BPM: 0</div>
                               
                                    <canvas id="bpmChart" ></canvas>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/smoothie@1.36.0/smoothie.js"></script>
<script>
    const bpmResultElement = document.getElementById('bpm-result');
    const bpmChartCanvas = document.getElementById('bpmChart');
    
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
        let bpmValue = parseInt(data.bpm_value);

        // Append the BPM data to the time series
        bpmSeries.append(new Date().getTime(), bpmValue);

        // Update the result in the view
        bpmResultElement.innerText = "Latest BPM: " + Math.round(bpmValue / 4);
    });

    // Ensure canvas is resized during each frame render
    setInterval(function() {
        resizeCanvas();  // Adjust the canvas width dynamically as the container size changes
    }, 1000);
</script>







@endsection
