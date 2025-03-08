@extends('layouts.patient')

@section('content')
<div class="row w-100 h-100 align-items-center containerShadow2">
    <div class="col">
        <div class="row">
            <div class="col d-flex flex-column" style="min-height:100vh; max-height:100vh;">
                <div class="row color7 p-2">
                    <div class="col textstyle5" style="font-size: 1.3rem">
                        @if($selectedEmployeeId)
                            Dr. {{ $employees->find($selectedEmployeeId)->username }}
                            
                        @else
                            Chat
                        @endif
                    </div>
                    <div class="col">
                        <button id="startVideoCall" class="custom-button float-end p-1"
                            data-url="{{ $selectedEmployeeId ? route('startVideoCall', ['employee_id' => $selectedEmployeeId]) : '#' }}">
                            Video Call
                            <i class="fa-solid fa-video"></i>
                        </button>
                    </div>
                </div>
                <div class="row flex-grow-1">
                    <div class="col p-0">
                        <div id="buttonContainer" class="p-2">
                                        
                        </div>
                        <div id="messages" class="" style="max-height: 85vh; padding: 15px; overflow-y: auto; overflow-x: hidden;">
                            
                            @if($chat)
                                @foreach($messages as $message)
                                    <div class="message {{ $message->sender_type == 'patient' ? 'outgoing' : 'incoming' }}">
                                        {{ $message->message }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                </div>
                @if($chat)
                    <div class="row mb-2 px-3">
                        <div class="col">
                            <div class="row">
                                <div class="col p-0">
                                    <input type="text" id="message" class="form-control">
                                </div>
                                <div class="col-auto p-0">
                                    <button id="send" class="btn btn-dark color7">Send <i class="fa-regular fa-paper-plane ms-1" style="font-size:0.8rem"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>        
    </div>

    <!-- Care Team Section -->
    <div class="col-2 d-none d-md-block" style="min-height:100vh; max-height:100vh; border-left:2px solid lightgray">
        <div class="row color7 p-2">
            <div class="col textstyle5" style="font-size: 1.3rem">
                Care Team
            </div>
        </div>
        <div class="row">
            <div class="col">
                @foreach($employees as $employee)
                    <a href="{{ route('showLiveChatPage', ['employee_id' => $employee->id]) }}" 
                       class="row text-decoration-none hover-effect p-3 employee-link employee-{{ $employee->id }} {{ $selectedEmployeeId == $employee->id ? 'selected' : '' }}" 
                       data-employee-id="{{ $employee->id }}">
                            <div class="col d-flex align-items-center">
                                {{ $employee->username }}
                            </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="bubble-icon d-md-none" style="position: fixed; bottom: 60px; right: 20px; z-index: 1000;">
        <button type="button" class="btn btn-primary rounded-circle position-relative" data-bs-toggle="modal" data-bs-target="#careTeamModal">
            <i class="fa fa-comments"></i>
            <span id="bubble-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">1</span>
        </button>
    </div>

</div>

<div class="modal fade" id="careTeamModal" tabindex="-1" aria-labelledby="careTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="careTeamModalLabel">Care Team</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach($employees as $employee)
                    <a href="{{ route('showLiveChatPage', ['employee_id' => $employee->id]) }}" 
                       class="row text-decoration-none hover-effect p-3 employee-link employee-{{ $employee->id }} {{ $selectedEmployeeId == $employee->id ? 'selected' : '' }}" 
                       data-employee-id="{{ $employee->id }}">
                            <div class="col d-flex align-items-center">
                                {{ $employee->username }}
                            </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    var selectedChatId = '{{ $chat->id ?? '' }}';
    var unreadMessages = {};  // To track unread messages for each employee

    var pusher = new Pusher('3b6b01805bb66418b849', {
        cluster: 'ap1',
        forceTLS: false
    });

    function loadMessages(chatId) {
        if (!chatId) return;

        $.ajax({
            url: '/patient/getMessages/' + chatId,
            type: 'GET',
            success: function(response) {
                $('#messages').html(''); 
                response.messages.forEach(function(message) {
                    var messageClass = message.sender_type === 'patient' ? 'outgoing' : 'incoming';
                    $('#messages').append('<div class="message ' + messageClass + '">' + message.message + '</div>');
                });
                $('#messages').scrollTop($('#messages')[0].scrollHeight); 
                console.log("Messages loaded for chatId:", chatId, "Messages:", response.messages);
            },
            error: function(xhr, status, error) {
                console.error("Failed to load messages for chatId:", chatId, "Error:", error);
            }
        });
    }

    function subscribeToChatChannel(chatId) {
        if (!chatId) return; 
        
        console.log("Subscribing to chat channel for chatId:", chatId);
        
        var channel = pusher.subscribe('chat.' + chatId); 

        channel.bind('App\\Events\\MessageSent', function(data) {
            if (data.message) {
                var messageClass = data.message.sender_type === 'patient' ? 'outgoing' : 'incoming';
                $('#messages').append('<div class="message ' + messageClass + '">' + data.message.message + '</div>');
                $('#messages').scrollTop($('#messages')[0].scrollHeight); 

                console.log("Incoming message received:", data.message);

                // Handle badges if the message is from an employee
                if (data.message.sender_type !== 'patient') {
                    addBadgeToEmployee(data.message.employee_id);
                    updateBubbleBadge();  
                }
            } else {
                console.error("Received message with missing data:", data);
            }
        });

        console.log("Subscribed to chat channel:", channel);

        channel.bind('App\\Events\\VideoCallFromAdminStarted', function(data) {
            console.log('Video call started:', data.videoCallUrl);

            $('#messages').append(
                '<div class="message incoming">An video call has initiated' +
                '<a href="' + data.videoCallUrl + '" class="btn btn-primary ms-2" target="_blank">' +
                'Join Now' +
                '</a></div>'
            );
            $('#messages').scrollTop($('#messages')[0].scrollHeight);

            console.log('Video call message and button added to chat.');

            $('#joinVideoCallButton').remove();

            $('#buttonContainer').append(
                '<a href="' + data.videoCallUrl + '" id="joinVideoCallButton" class="btn btn-primary">' +
                'Join Video Call Now' +
                '</a>'
            );


            console.log('Button appended: ', $('#joinVideoCallButton').length > 0);

        });
    }
    $('#startVideoCall').on('click', function() {
        
        $('#messages').append(
            '<div class="message outgoing">You have started a video call</div>'
        );
        $('#messages').scrollTop($('#messages')[0].scrollHeight); 

    });


    $('#send').on('click', function() {
        var message = $('#message').val();
        if (selectedChatId && message.trim() !== '') {
            console.log("Sending message:", message, "for chatId:", selectedChatId);
            $.ajax({
                url: '/patient/sendMessage/' + selectedChatId,
                type: 'POST',
                data: {
                    message: message,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#message').val('');  
                    loadMessages(selectedChatId);  
                    console.log("Message sent successfully");
                },
                error: function(xhr, status, error) {
                    console.error("Failed to send message:", error);
                }
            });
        } else {
            console.error('No chat ID available or message is empty.');
        }
    });

    if (selectedChatId) {
        loadMessages(selectedChatId);
        subscribeToChatChannel(selectedChatId);
    }

    $(document).ready(function() {
        $('.employee-link').on('click', function(e) {
            e.preventDefault(); 

            $('.employee-link').removeClass('selected');
            $(this).addClass('selected');

            var employeeId = $(this).data('employee-id'); // Get the selected employee ID

            // Update the video call button with the new URL
            var videoCallUrl = "{{ url('/video-call') }}/" + employeeId;
            $('#startVideoCall').attr('data-url', videoCallUrl);

            // Navigate to the employee chat page
            var href = $(this).attr('href');
            console.log("Navigating to employee chat page:", href);
            window.location.href = href;
        });

        $('#startVideoCall').on('click', function() {
            var videoCallUrl = $(this).data('url'); // Use the dynamically updated URL
            if (videoCallUrl) {
                window.open(videoCallUrl, '_blank', 'width=800,height=600');
            } else {
                console.error("Video call URL is missing.");
            }
        });
    });


    function subscribeToGlobalConversationsChannel() {
        console.log("Subscribing to global conversations channel.");
        
        var globalChannel = pusher.subscribe('conversations');

        globalChannel.bind('App\\Events\\employeeToPatient', function(data) {
            console.log('employeeToPatient event received:', data);

            if (data.employee_id) {
                addBadgeToEmployee(data.employee_id); 
                updateBubbleBadge();  
            } else {
                console.error("Received employeeToPatient event with undefined employee_id:", data);
            }
        });
    }

    function updateBubbleBadge() {
        let totalUnread = Object.keys(unreadMessages).reduce((total, employeeId) => {
            return total + unreadMessages[employeeId];
        }, 0);

        console.log("Total unread messages for bubble badge:", totalUnread);

        var bubbleBadge = $('#bubble-badge');
        if (totalUnread > 0) {
            bubbleBadge.text(totalUnread).show();
            console.log("Bubble badge updated:", totalUnread);
        } else {
            bubbleBadge.text('').hide();
            console.log("Bubble badge hidden");
        }
    }

    $('#careTeamModal').on('show.bs.modal', function () {
        console.log("Care Team modal opened. Resetting unread message counts.");

        $('#bubble-badge').text('');  
        $('#bubble-badge').hide();    

        Object.keys(unreadMessages).forEach(employeeId => {
            unreadMessages[employeeId] = 0;
            $('#badge-' + employeeId).text('').hide();
            console.log("Reset badge for employeeId:", employeeId);
        });
    });

    function addBadgeToEmployee(employeeId) {
        if (!employeeId) {
            console.error("Attempted to add badge with undefined employeeId.");
            return;
        }

        if (!unreadMessages[employeeId]) {
            unreadMessages[employeeId] = 0;
        }
        unreadMessages[employeeId]++;

        console.log("Updated unreadMessages count for employeeId:", employeeId, "Count:", unreadMessages[employeeId]);

        var targetElement = $('.employee-' + employeeId).find('.col');
        var badge = $('#badge-' + employeeId);

        if (badge.length === 0) {
            targetElement.append(
                '<span class="badge bg-danger ms-2 incoming-message-badge" id="badge-' + employeeId + '">' + unreadMessages[employeeId] + '</span>'
            );
            console.log("New badge added for employeeId:", employeeId);
        } else {
            badge.text(unreadMessages[employeeId]);
            console.log("Badge updated for employeeId:", employeeId, "New count:", unreadMessages[employeeId]);
        }

        badge.show();
    }

    $(document).ready(function() {
        // When an employee is clicked
        $('.employee-link').on('click', function(e) {
            e.preventDefault(); // Prevent default action to keep the selected class

            // Remove 'selected' class from all employees
            $('.employee-link').removeClass('selected');

            // Add 'selected' class to the clicked employee
            $(this).addClass('selected');

            var employeeId = $(this).data('employee-id'); // Get the selected employee ID

            // Update the video call button with the new URL
            var videoCallUrl = "{{ url('/video-call') }}/" + employeeId;
            $('#startVideoCall').attr('data-url', videoCallUrl);

            // Navigate to the employee chat page
            var href = $(this).attr('href');
            console.log("Navigating to employee chat page:", href);
            window.location.href = href;
        });
    });


    subscribeToGlobalConversationsChannel();
</script>


@endsection
