<div>
    @section('title')
        Work From Home
    @endsection

    @push('styles')
        <style>
            video {
                background: #222;
                margin: 0 0 20px 0;
                --width: 100%;
                width: var(--width);
                height: calc(var(--width) * 0.75);
            }
        </style>
    @endpush

    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="row">
                <div class="col-md-8 mt-3 position-relative">
                    <video id="localVideo" autoplay muted playsinline style="width: 300px;"></video>
                    <button id="toggleCameraBtn">Open camera</button>
                    <div class="text-center mt-2"></div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <select class="form-select form-select-md mt-4" name="" id="">
                            <option selected>Select status</option>
                            <option value="">Master 1</option>
                            <option value="">Master 2</option>
                            <option value="">Master 3</option>
                        </select>
                    </div>
                    <div class="vstack gap-3">
                        <button type="button" id="startPeerBtn" class="btn btn-success col-12">Start</button>
                        <button type="button" id="endPeerBtn" class="btn btn-danger col-12">End</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        import Peer from "https://esm.sh/peerjs@1.5.4?bundle-deps";

        let peer = null;
        let localStream = null;
        let cameraOn = false;
        let sessionRunning = false;
        let currentPeerId = null;

        // Camera toggle logic
        const toggleCameraBtn = document.getElementById('toggleCameraBtn');
        const localVideo = document.getElementById('localVideo');
        const startPeerBtn = document.getElementById('startPeerBtn');
        const endPeerBtn = document.getElementById('endPeerBtn');

        toggleCameraBtn.addEventListener('click', async () => {
            if (!cameraOn) {
                try {
                    localStream = await navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: false
                    });
                    localVideo.srcObject = localStream;
                    cameraOn = true;
                    toggleCameraBtn.textContent = 'Close camera';
                } catch (err) {
                    alert('Could not access camera');
                }
            } else {
                // Stop all tracks
                if (localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                    localVideo.srcObject = null;
                }
                cameraOn = false;
                toggleCameraBtn.textContent = 'Open camera';
            }
        });

        // PeerJS logic
        startPeerBtn.addEventListener('click', async () => {
            if (sessionRunning) return; // Prevent multiple sessions

            startPeerBtn.disabled = true;

            peer = new Peer({
                host: 'pm-app.test',
                port: 9000,
                path: '/peerjs'
            });

            peer.on('open', async (id) => {
                currentPeerId = id;
                sessionRunning = true;
                // Store peer id in DB as session started
                await fetch('/store-peer-id', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        peer_id: id,
                        session_status: 'started'
                    })
                });
            });

            peer.on('call', function(call) {
                if (localStream) {
                    call.answer(localStream);
                } else {
                    alert('Please turn on your camera before answering the call.');
                }
            });
        });

        // End PeerJS session and update DB
        endPeerBtn.addEventListener('click', async () => {
            if (peer) {
                peer.destroy();
                peer = null;
            }
            if (sessionRunning && currentPeerId) {
                // Update DB as session ended
                await fetch('/update-peer-session', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        peer_id: currentPeerId,
                        session_status: 'ended'
                    })
                });
            }
            sessionRunning = false;
            currentPeerId = null;
            startPeerBtn.disabled = false;
        });
    </script>
@endpush
