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

                    {{-- <video id="gum-local" autoplay playsinline></video> --}}

                    <video id="localVideo" autoplay muted playsinline style="width: 300px;"></video>
                    {{-- <video id="localVideo" playsinline autoplay muted></video> --}}
                    <button id="showVideo">Open camera</button>
                    {{-- <video id="remoteVideo" playsinline autoplay></video> --}}

                    {{-- <video id="localVideo" autoplay muted playsinline class="w-full rounded-xl"
                        style="width: 100%; height:auto"></video> --}}
                    <div class="text-center mt-2">
                        {{-- <button id="toggleCamera" class="btn btn-warning">
                            <i id="cameraIcon" class="fas fa-video"></i> Camera
                        </button> --}}
                    </div>
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
                        <button type="button" class="btn btn-success col-12">Start</button>
                        <button type="button" class="btn btn-danger col-12">End</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>Today</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>This week</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>This month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>Performance</p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

@push('scripts')
    <script type="module">
        import Peer from "https://esm.sh/peerjs@1.5.4?bundle-deps";

        let localStream;
        const localVideo = document.getElementById('localVideo');
        const showVideoBtn = document.getElementById('showVideo');

        // Initialize PeerJS
        const peer = new Peer({
            host: 'pm-app.test',
            port: 9000,
            path: '/peerjs',
            debug: 3,
            // proxied: true,
        });

        // Open camera and display local stream
        showVideoBtn.addEventListener('click', async () => {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                });
                localVideo.srcObject = localStream;
            } catch (err) {
                alert('Could not access camera/microphone: ' + err);
            }
        });

        // Listen for incoming calls
        peer.on('call', call => {
            call.answer(localStream); // Answer the call with your stream
            call.on('stream', remoteStream => {
                // You can add a remote video element to display remoteStream if needed
            });
        });

        // Example: To call another peer (replace 'remote-peer-id' with actual ID)
        // const call = peer.call('remote-peer-id', localStream);

        // Optional: Handle peer connection open
        peer.on('open', id => {
            console.log('My peer ID is: ' + id);
        });
    </script>
@endpush
