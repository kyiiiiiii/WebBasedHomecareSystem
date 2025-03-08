<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Call</title>
    <script src="https://unpkg.com/@daily-co/daily-js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Video Call with {{$chat->employee->username}}</h1>
    <div id="video-call-container"></div>
    <script>
        const callFrame = window.DailyIframe.createFrame({
            showLeaveButton: true,
            showFullscreenButton: true,
            showParticipantsBar: true,
            iframeStyle: {
                width: "100%",
                height: "100vh",
                border: "0"
            }
        });

        callFrame.join({ url: "{{ $roomUrl }}" });
        document.getElementById('video-call-container').appendChild(callFrame.iframe());

        function deleteRoom() {
            $.ajax({
                url: "/delete-room",
                type: "POST",
                data: {
                    roomUrl: "{{ $roomUrl }}",
                    employee_id:"{{$employee_id}}", // Pass the dynamic room URL from your backend
                    _token: "{{ csrf_token() }}" // Include CSRF token
                },
                success: function (response) {
                    console.log("Room deleted successfully");
                },
                error: function (error) {
                    console.error("Error deleting room:", error);
                }
            });
        }

        window.addEventListener("unload", function (e) {
            deleteRoom();
        });
    </script>
</body>
</html>
