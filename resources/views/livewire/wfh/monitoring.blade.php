<div>
    @section('title')
        Monitoring Work From Home
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
                    <video id="remoteVideo" autoplay></video>

                    {{-- <video id="localVideo" autoplay muted playsinline class="w-full rounded-xl"
                        style="width: 100%; height:auto"></video> --}}
                    <div class="text-center mt-2">
                        {{-- <button id="toggleCamera" class="btn btn-warning">
                            <i id="cameraIcon" class="fas fa-video"></i> Camera
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        import {
            Peer
        } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

        // const monitoringPeerId = '123';


        var peer = new Peer({
            host: 'pm-app.test',
            port: 9000,
            path: '/peerjs',
            debug: 3,
            // proxied: true,
        });

        peer.on('open', function(id) {
            console.log('My peer ID is: ' + id);
            // document.getElementById('my-id').textContent = id;
        });

        peer.on('connection', function(conn) {
            conn.on('data', function(data) {
                // Will print 'hi!'
                console.log(data);
            });
        });

        // Handle incoming calls and display remote stream
        peer.on('call', function(call) {
            // Get user media (camera and microphone)
            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                })
                .then(function(localStream) {
                    call.answer(localStream); // Answer the call with local stream
                    call.on('stream', function(remoteStream) {
                        const remoteVideo = document.getElementById('remoteVideo');
                        if ('srcObject' in remoteVideo) {
                            remoteVideo.srcObject = remoteStream;
                        } else {
                            remoteVideo.src = window.URL.createObjectURL(remoteStream);
                        }
                        remoteVideo.play();
                    });
                })
                .catch(function(err) {
                    console.error('Failed to get local stream', err);
                    call.answer(); // Answer without stream if permission denied
                });
        });
    </script>
@endpush
