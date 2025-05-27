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

<!-- resources/views/livewire/work-from-home.blade.php -->
@push('scripts')
    <script type="module">
        import Peer from "https://esm.sh/peerjs@1.5.4?bundle-deps";

        let peer = null;
        let localStream = null;
        let cameraOn = false;
        let sessionRunning = false;
        let currentPeerId = null;

        // DOM Elements
        const toggleCameraBtn = document.getElementById('toggleCameraBtn');
        const localVideo = document.getElementById('localVideo');
        const startPeerBtn = document.getElementById('startPeerBtn');
        const endPeerBtn = document.getElementById('endPeerBtn');

        // Toggle camera on/off
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
                    alert('Could not access camera: ' + err.message);
                }
            } else {
                // Stop camera
                if (localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                    localVideo.srcObject = null;
                    localStream = null;
                }
                cameraOn = false;
                toggleCameraBtn.textContent = 'Open camera';
            }
        });

        // Start PeerJS and register session
        startPeerBtn.addEventListener('click', async () => {
            if (sessionRunning) return;

            if (!cameraOn || !localStream) {
                alert('Please turn on your camera first.');
                return;
            }

            startPeerBtn.disabled = true;

            peer = new Peer({
                host: 'pm-app.test',
                port: 9000,
                path: '/peerjs',
                secure: true,
                key: 'peerjs',
                debug: 3,
                config: {
                    'iceServers': [{
                        urls: 'stun:stun.l.google.com:19302'
                    }]
                }
            });

            // PeerJS Open
            peer.on('open', async (id) => {
                currentPeerId = id;
                sessionRunning = true;

                // Store peer_id to backend
                await fetch('/store-peer-id', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content,
                        'X-Socket-Id': window.Echo.socketId,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        peer_id: id
                    })
                });
            });

            // Handle incoming call
            peer.on('call', (call) => {
                console.log('Incoming call from:', call.peer);

                if (!localStream) {
                    console.warn('No local stream to answer call');
                    return;
                }

                call.answer(localStream);

                call.on('close', () => {
                    console.log('Call closed by peer:', call.peer);
                });

                call.on('error', (err) => {
                    console.error('Call error:', err);
                });
            });

            peer.on('error', (err) => {
                console.error('PeerJS error:', err);
            });
        });

        // Stop PeerJS and update session
        endPeerBtn.addEventListener('click', async () => {
            if (peer) {
                peer.destroy();
                peer = null;
            }

            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
                localVideo.srcObject = null;
                localStream = null;
            }

            if (sessionRunning && currentPeerId) {
                await fetch('/update-peer-session', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Socket-Id': window.Echo.socketId,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        peer_id: currentPeerId
                    })
                });
            }

            cameraOn = false;
            sessionRunning = false;
            currentPeerId = null;
            startPeerBtn.disabled = false;
            toggleCameraBtn.textContent = 'Open camera';
        });
    </script>
@endpush
