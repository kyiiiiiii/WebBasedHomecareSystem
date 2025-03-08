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
    <script src="https://kit.fontawesome.com/8f346613dd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="{{ mix('js/circliful.custom.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/calendar.js') }}"></script>
    <link  href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet">
    <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
    <script src="{{ asset('js/cropper.js') }}"></script>
    
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto color7 sticky-sidebar">
                <div class="main-content">
                    <div class="row">
                        <div class="col py-3 p-md-3 d-none d-lg-flex" style="font-size:2rem; font-weight:bold; color:white;">Care4U</div>
                    </div>
                    <div class="row mt-5 mt-lg-0 ">
                        <a href="{{route("showPatientHome")}}" class="col customContainer3 text-decoration-none">
                            <div class="row py-3 p-md-3 d-flex align-items-center">
                                <i class="col-12 col-lg-1 fa-solid fa-house text-center textstyle" style="font-size: 1rem"></i>
                                <div class="col d-none d-lg-block textstyle d-flex align-items-center">
                                    Home
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="row">
                        <a href="{{route("showAppointmentPage")}}" class="col customContainer3 text-decoration-none">
                            <div class="row py-3 p-md-3 d-flex align-items-center">
                                <i class="col-12 col-lg-1 fa-solid fa-calendar-days text-center textstyle" style="font-size: 1rem"></i>
                                <div class="col d-none d-lg-block textstyle d-flex align-items-center">
                                    Activity
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="row">
                        <a href="{{route("showCareDeliveryForm")}}" class="col customContainer3 text-decoration-none">
                            <div class="row py-3 p-md-3 d-flex align-items-center">
                                <i class="col-12 col-lg-1 fa-solid fa-hand-holding-medical text-center textstyle" style="font-size: 1rem"></i>
                                <div class="col d-none d-lg-block textstyle d-flex align-items-center">
                                    Care Delivery
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="row">
                        <a href="{{route('showPatientHealthRecord')}}" class="col customContainer3 text-decoration-none">
                            <div class="row py-3 p-md-3 d-flex align-items-center">
                                <i class="col-12 col-lg-1 fa-solid fa-heart text-center textstyle" style="font-size: 1rem"></i>
                                <div class="col d-none d-lg-block textstyle d-flex align-items-center">
                                    HealthCare Record
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <div class="row">
                        <a href="{{route('showCareTeamPage')}}" class="col customContainer3 text-decoration-none">
                            <div class="row py-3 p-md-3 d-flex align-items-center">
                                <i class="col-12 col-lg-1 fa-solid fa-users text-center textstyle" style="font-size: 1rem"></i>
                                <div class="col d-none d-lg-block textstyle d-flex align-items-center">
                                    Care Team
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="row">
                        <a href="{{route('showLiveChatPage')}}" class="col customContainer3 text-decoration-none">
                            <div class="row py-3 p-md-3 d-flex align-items-center">
                                <i class="col-12 col-lg-1 fa-solid fa-comment text-center textstyle" style="font-size: 1rem"></i>
                                <div class="col d-none d-lg-block textstyle d-flex align-items-center">
                                    Live Chat
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
            </div>
            <!-- Content area -->
            <div class="col p-1 pb-sm-3 px-sm-3 d-flex justify-content-center align-items-center" id="content" style="background-color: rgb(231, 231, 231)">
                @yield('content')

            </div>
            <div id="global-notification-container" style="position: fixed; top: 10px; right: 10px; z-index: 10000;">
               
            </div>
        </div>
    </div>
    <script>
        var pusher = new Pusher('3b6b01805bb66418b849', {
            cluster: 'ap1',
            forceTLS: false
        });
        function handleIncomingCall(data) {
            var patientAccountId = {{ session('patientAccountID') }}; // Ensure this variable is set correctly

            if (data.patientId == patientAccountId) {
                console.log('Incoming voice call for this patient:', data.callUrl);

                // Display an alert, notification, or modal to inform the user about the incoming call
                $('#global-notification-container').html(
                    '<div class="alert alert-info">You have an incoming voice call' +
                    '<a href="' + data.callUrl + '" class="btn btn-primary ms-2" target="_blank">' +
                    'Join Now' +
                    '</a></div>'
                );
            } else {
                console.log('Voice call notification received but not for this patient.');
            }
        }
        function removeCallNotification(data) {
            var patientAccountId = {{ session('patientAccountID') }};
            if (data.patientId == patientAccountId) {
                $('#global-notification-container').html(''); // Clear the notification container
            }else {
                console.log('Voice call ended but not for this patient.');
            }
        }

        $(document).ready(function() {
            var globalChannel = pusher.subscribe('global-notifications');

            globalChannel.bind('App\\Events\\VoiceCallNotificationToPatient', function(data) {
                handleIncomingCall(data);
            });

            globalChannel.bind('App\\Events\\VoiceCallEndedFromAdmin', function(data) {
                console.log('Voice call ended:', data.callUrl);
                removeCallNotification(data); 
            });
        });
    </script>
</body>
</html>
