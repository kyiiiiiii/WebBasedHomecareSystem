<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Care4U</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/circliful.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
        <script src="https://d3js.org/d3.v4.js"></script>
        <script src="https://kit.fontawesome.com/8f346613dd.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
        <link  href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet">
        <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
        <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <script src="{{ mix('js/circliful.custom.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/chart.js') }}"></script>
        <script src="{{ asset('js/cropper.js') }}"></script>
        <script src="{{ asset('js/calendar.js') }}"></script>
        <script src="{{ asset('js/d3.js') }}"></script>
        <script src="https://unpkg.com/@daily-co/daily-js"></script>

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto col-md-2 color2 sticky-sidebar">
                    <div class="main-content">
                        <div class="row d-block d-lg-none">
                            <div class="col p-2 d-flex justify-content-center text-align-center">
                                <div class="textstyle5" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                                    <i class="fa-solid fa-bars"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col p-3 d-none d-lg-flex" style="font-size:2rem; font-weight:bold; color:white;">Care4U</div>
                        </div>
                        <div class="row d-none d-lg-flex">
                            <a href="{{ route('showAdminHome') }}" class="col customContainer3 text-decoration-none">

                                <div class="row p-3 d-flex align-items-center">
                                    <i class="col-1 col-lg-1 fa-solid fa-house text-center textstyle " style="font-size: 1rem"></i>
                                    <div class="col  textstyle d-flex align-items-center">
                                        Home
                                    </div>
                                </div>
                            </a>
                        </div>
    
                        <div class="row d-none d-lg-flex">
                            <a href="#submenu1" data-bs-toggle="collapse" class="col customContainer3 text-decoration-none">
                                <div class="row p-3 d-flex align-items-center">
                                    <i class="col-1 col-lg-1 fa-solid fa-layer-group text-center textstyle " style="font-size: 1rem"></i>
                                    <div class="col  textstyle d-flex align-items-center">
                                        Care Services<i class="fa-solid fa-caret-down ms-2 textstyle"></i>
                                    </div>
                                </div>
                            </a>
                            <ul class="collapse nav flex-column" id="submenu1" data-bs-parent="#menu">
                                <div class="col">
                                    <li class="row p-2 ps-4 customContainer3 color3">
                                        <a href="{{route("adminAppointment")}}" class="col text-decoration-none"> 
                                            <div class="row textstyle2 align-items-center d-flex justify-content-center ">
                                                <i class="col-1  fa-solid fa-arrow-right me-2 textstyle"></i>
                                                <div class="col ">Appointments</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="row p-2 ps-4 customContainer3 color3">
                                        <a href="{{route("showPrescriptionPage")}}" class="col text-decoration-none"> 
                                            <div class="row textstyle2 align-items-center d-flex justify-content-center">
                                                <i class="col-1  fa-solid fa-arrow-right me-2 textstyle"></i>
                                                <div class="col ">Prescription Delivery</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="row p-2 ps-4 customContainer3 color3">
                                        <a href="{{route("showCareDeliveryPage")}}" class="col text-decoration-none"> 
                                            <div class="row textstyle2 align-items-center d-flex justify-content-center">
                                                <i class="col-1  fa-solid fa-arrow-right me-2 textstyle"></i>
                                                <div class="col ">Care Delivery</div>
                                            </div>
                                        </a>
                                    </li>
                                </div>
                            </ul>
                        </div>
    
                        <div class="row d-none d-lg-flex">
                            <a href="{{route("patientInfo")}}" class="col customContainer3 text-decoration-none">
                                <div class="row p-3 d-flex align-items-center">
                                    <i class="col-1 col-lg-1 fa-solid fa-user text-center textstyle d-none d-lg-flex" style="font-size: 1rem"></i>
                                    <div class="col  textstyle d-flex align-items-center">
                                        Patient Information
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="row d-none d-lg-flex">
                            <a href="{{route("empInfo")}}" class="col customContainer3 text-decoration-none">
                                <div class="row p-3 d-flex align-items-center">
                                    <i class="col-1 col-lg-1 fa-solid fa-user-tie text-center textstyle d-none d-lg-flex" style="font-size: 1rem"></i>
                                    <div class="col  textstyle d-flex align-items-center">
                                        Employees
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="row d-none d-lg-flex">
                            <a href="{{route("admin.showChatPage")}}" class="col customContainer3 text-decoration-none">
                                <div class="row p-3 d-flex align-items-center">
                                    <i class="col-1 col-lg-1 fa-solid fa-message text-center textstyle " style="font-size: 1rem"></i>
                                    <div class="col  textstyle d-flex align-items-center">
                                        Chat With Patient
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                    </div> 
                    <div class="footer-content d-none d-lg-flex">
                        <div class="pb-4">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                
                                <span class="d-none d-lg-flex mx-1">
                                    @if(session('employeeAccountName'))
                                        {{ session('employeeAccountName') }}
                                    @endif
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                <li><a class="dropdown-item" href="{{route('empProfile')}}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{route('admin.login')}}">Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Content area -->
                <div class="col p-1 pb-sm-3 px-sm-3 d-flex justify-content-center align-items-center" id="content" style="background-color: rgb(231, 231, 231)" id="content">
                    @yield('content')
                </div>
                <div id="global-notification-container" style="position: fixed; top: 10px; right: 10px; z-index: 10000;">
               
                </div>
        </div>
    
        <div class="offcanvas offcanvas-start color6" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title text-white" id="sidebarLabel">Care4U</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 px-3" id="menu">
                    <div class="row ">
                        <a href="{{ route('showAdminHome') }}" class="col customContainer3 text-decoration-none">
                            <div class="row p-3 d-flex align-items-center">
                                <i class="col-1 col-lg-1 fa-solid fa-house text-center textstyle " style="font-size: 1rem"></i>
                                <div class="col  textstyle d-flex align-items-center">
                                    Home
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="row ">
                        <a href="#submenu1" data-bs-toggle="collapse" class="col customContainer3 text-decoration-none">
                            <div class="row p-3 d-flex align-items-center">
                                <i class="col-1 col-lg-1 fa-solid fa-layer-group text-center textstyle " style="font-size: 1rem"></i>
                                <div class="col  textstyle d-flex align-items-center">
                                    Care Services<i class="fa-solid fa-caret-down ms-2 textstyle"></i>
                                </div>
                            </div>
                        </a>
                        <ul class="collapse nav flex-column" id="submenu1" data-bs-parent="#menu">
                            <div class="col">
                                <li class="row p-2 ps-4 customContainer3 color3">
                                    <a href="{{route("adminAppointment")}}" class="col text-decoration-none"> 
                                        <div class="row textstyle2 align-items-center d-flex justify-content-center ">
                                            <i class="col-1  fa-solid fa-arrow-right me-2 textstyle"></i>
                                            <div class="col ">Appointments</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="row p-2 ps-4 customContainer3 color3">
                                    <a href="{{route("showPrescriptionPage")}}" class="col text-decoration-none"> 
                                        <div class="row textstyle2 align-items-center d-flex justify-content-center">
                                            <i class="col-1  fa-solid fa-arrow-right me-2 textstyle"></i>
                                            <div class="col ">Prescription Delivery</div>
                                        </div>
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </div>

                    <div class="row ">
                        <a href="{{route("patientInfo")}}" class="col customContainer3 text-decoration-none">
                            <div class="row p-3 d-flex align-items-center">
                                <i class="col-1 col-lg-1 fa-solid fa-user text-center textstyle " style="font-size: 1rem"></i>
                                <div class="col  textstyle d-flex align-items-center">
                                    Patient Information
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="row ">
                        <a href="#submenu2" data-bs-toggle="collapse" class="col customContainer3 text-decoration-none">
                            <div class="row p-3 d-flex align-items-center">
                                <i class="col-1 col-lg-1 fa-solid fa-user-tie text-center textstyle " style="font-size: 1rem"></i>
                                <div class="col  textstyle d-flex align-items-center">
                                    Employees<i class="fa-solid fa-caret-down ms-2 textstyle"></i>
                                </div>
                            </div>
                        </a>
                        <ul class="collapse nav flex-column  " id="submenu2" data-bs-parent="#menu" style="background-color:red">
                            <div class="col">
                                <li class="row p-2 ps-4 customContainer3 color3">
                                    <a href="{{route("empInfo")}}" class=" text-decoration-none"> 
                                        <div class="row textstyle2 align-items-center d-flex justify-content-center ">
                                            <i class="col-1  fa-solid fa-arrow-right me-2 textstyle"></i>
                                            <div class="col ">Employees Information</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="row p-2 ps-4 customContainer3 color3">
                                    <a href="/taskManagement" class=" text-decoration-none"> 
                                        <div class="row textstyle2 align-items-center d-flex justify-content-center ">
                                            <i class="col-1 fa-solid fa-arrow-right me-2 textstyle"></i>
                                            <div class="col ">Employees Task</div>
                                        </div>
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </div>
                    <div class="row ">
                        <a href="{{route("admin.showChatPage")}}" class="col customContainer3 text-decoration-none">
                            <div class="row p-3 d-flex align-items-center">
                                <i class="col-1 col-lg-1 fa-solid fa-message text-center textstyle " style="font-size: 1rem"></i>
                                <div class="col  textstyle d-flex align-items-center">
                                    Chat With Patient
                                </div>
                            </div>
                        </a>
                    </div>
                </div> 

                <div class="footer-content ">
                    <div class="pb-4 px-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            
                            <span class="mx-1">
                                @if(session('employeeAccountName'))
                                    {{ session('employeeAccountName') }}
                                @endif
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="/empProfile">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{route('admin.login')}}">Sign out</a></li>
                        </ul>
                    </div>
                </div>
                </ul>
            </div>
        </div>
        <script>
            var pusher = new Pusher('3b6b01805bb66418b849', {
                cluster: 'ap1',
                forceTLS: false
            });
        
            function handleIncomingCall(data) {
                var employeeAccountId={{ session('employeeAccountID') }};
        
                if (data.employeeId == employeeAccountId) {
                    console.log('Incoming voice call for this Employee:', data.callUrl);
        
                    $('#global-notification-container').html(
                        '<div class="alert alert-info">You have an incoming voice call' +
                        '<a href="' + data.callUrl + '" class="btn btn-primary ms-2" target="_blank">' +
                        'Join Now' +
                        '</a></div>'
                    );
                } else {
                    console.log('Voice call notification received but not for this Employee.');
                }
            }

            function removeCallNotification(data) {
                var employeeAccountId={{ session('employeeAccountID') }};
                if (data.employeeId == employeeAccountId) {
                    $('#global-notification-container').html(''); 
                }else {
                    console.log('Voice call ended but not for this patient.');
                }
            }
        
            $(document).ready(function() {
                var globalChannel = pusher.subscribe('global-notifications');
        
                globalChannel.bind('App\\Events\\VoiceCallNotificationToAdmin', function(data) {
                    console.log("Incoming video call");
                    handleIncomingCall(data);
                });

                globalChannel.bind('App\\Events\\VoiceCallEndedFromPatient', function(data) {
                    console.log('Voice call ended:', data.callUrl);
                    removeCallNotification(data); 
                });
            });
        </script>
        
    </body>
</html>
