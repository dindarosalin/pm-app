<div>
    @section('title')
        Work From Home
    @endsection
    <div class="col-xl-8 col-md-8 col-sm-12">
        <div class="card">
            <video id="employeeVideo" autoplay playsinline></video>   
        </div>
        
    </div>

    @push('scripts')
    <script>
        const videoElement = document.getElementById('employeeVideo');
        let peerConnection;
        const config = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] }; // STUN Server untuk WebRTC

        async function startWebcam() {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
            videoElement.srcObject = stream;

            // Kirim stream ke HRD
            startWebRTC(stream);
        }

        function startWebRTC(stream) {
            peerConnection = new RTCPeerConnection(config);
            stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));

            peerConnection.onicecandidate = event => {
                if (event.candidate) {
                    sendToServer('candidate', event.candidate);
                }
            };

            peerConnection.createOffer().then(offer => {
                peerConnection.setLocalDescription(offer);
                sendToServer('offer', offer);
            });

            peerConnection.ontrack = event => {
                console.log("Receiving Stream from Employee");
            };
        }

        function sendToServer(type, data) {
            // Gantilah ini dengan WebSockets, Firebase, atau Socket.io
            console.log("Sending", type, data);
        }

        startWebcam();
    </script>
        
    @endpush
    
</div>
