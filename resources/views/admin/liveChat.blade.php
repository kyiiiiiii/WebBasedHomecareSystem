@extends('layouts.admin')

@section('content')
<div class="row w-100 h-100 align-items-center containerShadow2">
    <div class="col">
        <div class="row">
            <div class="col d-flex flex-column" style="min-height:100vh; max-height:100vh;">
                <div class="row color2 p-2">
                    <div class="col patient-name-header textstyle5" style="font-size: 1.3rem">
                        @if($chat && $chat->patient)
                            {{ $chat->patient->username }}
                        @else
                            Chat
                        @endif
                    </div>
                    <div class="col">     
                        <button id="startVideoCall" class="custom-button float-end p-1"
                                data-url="{{ $chat && $chat->patient ? route('AdminStartVideoCall', ['patient_id' => $chat->patient->id]) : '#' }}">
                            Video Call
                            <i class="fa-solid fa-video"></i>
                        </button>
                    </div>                
                </div>
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col p-2" style="min-height: 84vh; max-height: 84vh; overflow-y: auto; overflow-x: hidden;">
                                <div id="buttonContainer">
                                       
                                </div>
                                <div id="messages" class="messages-container">
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 px-3 " id="messageInputRow" style="display: none;">
                    <div class="col p-0">
                        <input type="text" id="message" class="message-input form-control" placeholder="Send Message ..." style="background-color:rgb(204, 198, 198)">
                    </div>
                    <div class="col-auto p-0">
                        <button id="send" class="send-message-btn btn btn-dark color2">Send <i class="fa-regular fa-paper-plane ms-1" style="font-size:0.8rem"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="recent-conversations" class="col-2 d-none d-md-block" style="min-height:100vh; max-height:100vh; border-left:2px solid lightgray">
        <div class="row color2 p-2">
            <div class="conversation-history-header textstyle5" style="font-size: 1.3rem">
                History
            </div>
        </div>
        <div class="row">
            <div class="col conversation-list"> 
                @foreach($chats as $chat)
                @if($chat->patient)
                    <a href="#" class="row custom-chat-item p-3 text-decoration-none text-dark" data-chat-id="{{ $chat->id }}" data-patient-id="{{ $chat->patient->id }}">
                        <div class="col chat-username textstyle3">
                            {{ $chat->patient->username }}
                            
                            <span class="badge bg-danger ms-2 incoming-message-badge" id="badge-{{ $chat->id }}" style="display: none;"></span>
                        </div>
                    </a>
                @else
                    <p>Patient not found for this chat.</p>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="bubble-icon d-md-none" style="position: fixed; bottom: 50px; right: 20px; z-index: 1000;">
        <button type="button" class="btn btn-primary rounded-circle position-relative " data-bs-toggle="modal" data-bs-target="#conversationHistoryModal">
            <i class="fa fa-comments"></i>
            <span id="bubble-badge" class="position-absolute top-50 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">0</span>
        </button>
    </div>
</div>

<div class="modal fade" id="conversationHistoryModal" tabindex="-1" aria-labelledby="conversationHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="conversationHistoryModalLabel">History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="conversation-list"> 
                    @foreach($chats as $chat)
                    <a href="#" class="row custom-chat-item p-3 text-decoration-none text-dark" data-chat-id="{{ $chat->id }}" data-patient-id="{{ $chat->patient->id }}">
                        <div class="col chat-username textstyle3">
                            {{ $chat->patient->username }}
                            <span class="badge bg-danger ms-2 incoming-message-badge" id="modal-badge-{{ $chat->id }}" style="display: none;border-radius: 50%;">
                                <i class="fa-regular fa-message"></i>
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        var selectedChatId = ''; 
        var patientId= ''; 
        var unreadMessages = {};  
        var pusher = new Pusher('3b6b01805bb66418b849', {
            cluster: 'ap1',
            forceTLS: false
        });
        
        $(document).ready(function() {
            $('#recent-conversations, #conversationHistoryModal').on('click', '.custom-chat-item', function(e) {
                e.preventDefault();

                $('.custom-chat-item').removeClass('selected-chat');
                $(this).addClass('selected-chat');

                selectedChatId = $(this).data('chat-id'); // Get the selected chat ID
                patientId = $(this).data('patient-id'); // Get the patient ID

                console.log('Selected chat ID:', selectedChatId);
                console.log('Patient ID:', patientId);

                pusher.unsubscribe('chat.' + selectedChatId);

                subscribeToChatChannel(selectedChatId);
                loadMessages(selectedChatId);

                var patientName = $(this).find('.chat-username').text();
                $('.patient-name-header').text(patientName);

                $('#messageInputRow').show();

                resetUnreadMessages(selectedChatId);

                // Update the video call button with the new URL
                var videoCallUrl = "{{ url('/admin/video-call') }}/" + patientId;
                console.log('Video Call URL:', videoCallUrl); // Ensure this is correct
                $('#startVideoCall').attr('data-url', videoCallUrl);
            });


            $('#startVideoCall').on('click', function() {
                var videoCallUrl = $(this).data('url'); // Use the dynamically updated URL
                if (videoCallUrl) {
                    window.open(videoCallUrl, '_blank', 'width=800,height=600');
                } else {
                    console.error("Video call URL is missing.");
                }
            });

            if (selectedChatId) {
                subscribeToChatChannel(selectedChatId);
            }

            subscribeToGlobalConversationsChannel();
        });

        function loadMessages(chatId) {
    if (!chatId) return;
    console.log('Loading messages for chat ID:', chatId);
    $.ajax({
        url: '/admin/getMessages/' + chatId,
        type: 'GET',
        success: function(response) {
            $('.messages-container').html('');
            response.messages.forEach(function(message) {
                var messageClass = message.sender_type === 'patient' ? 'incoming' : 'outgoing';
                var messageContent = message.message;

                // Check if the message indicates a video call and add a "Join Now" button
                if (messageContent.includes("You have started a video call")) {
                    var videoCallUrl = extractVideoCallUrl(messageContent); // Assume you have a function to extract the URL
                    messageContent += '<br><a href="' + videoCallUrl + '" class="btn btn-primary ms-2" target="_blank">Join Now</a>';
                }

                // Check if the message contains a URL and create a link if it does
                var urlPattern = /(https?:\/\/[^\s]+)/g;
                messageContent = messageContent.replace(urlPattern, function(url) {
                    return '<a href="' + url + '" target="_blank">' + url + '</a>';
                });

                $('.messages-container').append('<div class="message ' + messageClass + '">' + messageContent + '</div>');
            });
            $('#messages').scrollTop($('#messages')[0].scrollHeight);
            console.log("Messages loaded for chatId:", chatId);
            resetUnreadMessages(chatId);
        },
        error: function(xhr, status, error) {
            console.error('Failed to load messages for chat ID:', chatId, "Error:", error);
        }
    });
}

    // Example function to extract the video call URL from the message content
    function extractVideoCallUrl(messageContent) {
        // Assuming the URL is at the end of the message or part of it
        var urlPattern = /(https?:\/\/[^\s]+)/g;
        var urls = messageContent.match(urlPattern);
        return urls ? urls[0] : '#'; // Return the first URL found or '#' if no URL is found
    }


    function subscribeToChatChannel(chatId) {
        if (!chatId) return;

        console.log('Subscribing to chat channel: chat.' + chatId);

        var channel = pusher.subscribe('chat.' + chatId);

        channel.bind('App\\Events\\MessageSent', function(data) {
            console.log('Message received for chat ID:', data.message.chat_id, data);
            if (data.message) {
                var messageClass = data.message.sender_type === 'patient' ? 'incoming' : 'outgoing';
                $('.messages-container').append('<div class="message ' + messageClass + '">' + data.message.message + '</div>');
                scrollToBottom();
                
                if (messageClass === 'incoming') {
                    console.log('Handling unread message for chat ID:', data.message.chat_id);
                    incrementUnreadMessages(data.message.chat_id);
                }
            }
        });

        channel.bind('App\\Events\\VideoCallFromPatientStarted', function(data) {
            console.log('Video call started:', data.videoCallUrl);

            $('#messages').append(
                '<div class="message incoming">A video call has been initiated' +
                '<a href="' + data.videoCallUrl + '" class="btn btn-primary ms-2" target="_blank">' +
                'Join Now' +
                '</a></div>'
            );
            $('#messages').scrollTop($('#messages')[0].scrollHeight);

            console.log('Video call message and button added to chat.');
             
        });
    }

    $('#startVideoCall').on('click', function() {
       
       $('#messages').append(
           '<div class="message outgoing">You have started a video call</div>'
       );
       $('#messages').scrollTop($('#messages')[0].scrollHeight); // Scroll to the bottom

    });
    function scrollToBottom() {
        var messagesContainer = $('.messages-container');
        messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
        console.log('Scrolled to bottom');
    }

    function subscribeToGlobalConversationsChannel() {
        var globalChannel = pusher.subscribe('conversations');

        globalChannel.bind('App\\Events\\NewConversationStarted', function(data) {
            console.log('NewConversationStarted event received:', data);
            updateRecentConversations(data.chat_id, data.patient_name);

            incrementUnreadMessages(data.chat_id);
        });
    }

    function incrementUnreadMessages(chatId) {
        if (!unreadMessages[chatId]) {
            unreadMessages[chatId] = 0;
        }
        unreadMessages[chatId]++;

        console.log('Updated unreadMessages count for chatId:', chatId, 'Count:', unreadMessages[chatId]);

        var badge = $('#badge-' + chatId);
        var modalBadge = $('#modal-badge-' + chatId);  


        badge.show();
        modalBadge.show();

        updateBubbleBadge();
    }

    function resetUnreadMessages(chatId) {
        unreadMessages[chatId] = 0;

        console.log('Reset unreadMessages for chatId:', chatId);

        var badge = $('#badge-' + chatId);
        var modalBadge = $('#modal-badge-' + chatId);  

        badge.text('').hide();
        modalBadge.text('').hide();

        updateBubbleBadge();
    }

    function updateBubbleBadge() {
        //let totalUnread = Object.values(unreadMessages).reduce((total, count) => total + count, 0);

        //console.log('Total unread messages for bubble badge:', totalUnread);

       // var bubbleBadge = $('#bubble-badge');
        //if (totalUnread > 0) {
       //     bubbleBadge.text(totalUnread).show();
        //    console.log('Bubble badge updated:', totalUnread);
       // } else {
       //     bubbleBadge.text('').hide();
        //    console.log('Bubble badge hidden');
       // }
    }

    function updateRecentConversations(chatId, patientName) {
        console.log('Updating recent conversations with chat ID:', chatId);
        
        if ($('#recent-conversations .custom-chat-item[data-chat-id="' + chatId + '"]').length === 0) {
            $('#recent-conversations .conversation-list').append(
                '<a href="#" class="row custom-chat-item p-3 text-decoration-none text-dark" data-chat-id="' + chatId + '">' +
                    '<div class="col chat-username">' + patientName + '</div>' +
                '</a>'
            );
        }

        if ($('#conversationHistoryModal .custom-chat-item[data-chat-id="' + chatId + '"]').length === 0) {
            $('#conversationHistoryModal .conversation-list').append(
                '<a href="#" class="row custom-chat-item p-3 text-decoration-none text-dark" data-chat-id="' + chatId + '">' +
                    '<div class="col chat-username">' + patientName + '</div>' +
                '</a>'
            );
        } else {
            console.log('Chat already exists in the conversation history.');
        }
    }

    $('.send-message-btn').on('click', function() {
        var message = $('.message-input').val();
        if (selectedChatId && message.trim() !== '') {
            console.log('Sending message for chat ID:', selectedChatId);
            $.ajax({
                url: '/admin/sendMessage/' + selectedChatId,
                type: 'POST',
                data: {
                    message: message,
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    $('.message-input').val('');
                    loadMessages(selectedChatId); 
                },
                error: function(xhr, status, error) {
                    console.error('Failed to send message:', error);
                }
            });
        }
    });

    subscribeToGlobalConversationsChannel();

    if (selectedChatId) {
        subscribeToChatChannel(selectedChatId);
    }
</script>

@endsection
