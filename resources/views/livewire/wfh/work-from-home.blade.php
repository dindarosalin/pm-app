<div>
    @section('title', 'Work From Home')

    @push('styles')
        <style>
            video {
                background: #222;
                margin: 0 0 20px 0;
                --width: 100%;
                width: var(--width);
                height: calc(var(--width) * 2);
            }
        </style>
    @endpush

    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="row">
                <div class="col-md-8 mt-3 position-relative">
                    <video id="localVideo" autoplay playsinline muted class="col-xl-12 col-md-12 col-sm-12"></video>
                    <button id="toggleCameraBtn">Open camer a</button>
                    <div class="text-center mt-2"></div>
                    <div id="peerStatus">Status: <span id="peerStatusText">Connecting...</span></div>
                    <div>ID: <span id="peerIdText">-</span></div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <select class="form-select form-select-md mt-4" name="" id="statusWfh">
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



    {{-- <div id="peerStatus">Status: <span id="peerStatusText">Connecting...</span></div>
    <div>ID: <span id="peerIdText">-</span></div>
    <video id="localVideo" autoplay playsinline muted></video> --}}


    <script type="module">
        import {
            Peer
        } from "https://esm.sh/peerjs@1.5.4?bundle-deps";



        let localStream = null;
        const localVideo = document.getElementById('localVideo');
        const statusText = document.getElementById('peerStatusText');
        const peerIdText = document.getElementById('peerIdText');

        const toggleCameraBtn = document.getElementById('toggleCameraBtn');
        const statusWfh = document.getElementById('statusWfh');
        const startPeerBtn = document.getElementById('startPeerBtn');
        const endPeerBtn = document.getElementById('endPeerBtn');

        // const cameraOn = false;

        let cameraOn = false;
        let peer = null;

        toggleCameraBtn.addEventListener('click', async () => {
            if (!cameraOn) {
                try {
                    localStream = await navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: false
                    });
                    localVideo.srcObject = localStream;
                    cameraOn = true;


                    console.log('Requesting camera access...');

                } catch (err) {
                    alert('Could not access camera: ' + err.message);
                }
            } else {
                localStream.getTracks().forEach(track => track.stop());
                localVideo.srcObject = null;
                cameraOn = false;
                console.log('Camera turned off');
            }
        });

        peer = new Peer({
            // host: 'pm-app.test',
            // port: 9000,
            // path: '/peerjs',
            secure: true, // Changed to false to avoid HTTPS issues
            debug: 3,
            config: {
                'iceServers': [{
                        urls: 'stun:stun.l.google.com:19302'
                    },
                    {
                        urls: 'stun:stun1.l.google.com:19302'
                    },
                    {
                        urls: 'turn:relay1.expressturn.com:3480',
                        username: '000000002063784502',
                        credential: 'yJNV6kn+ZsS9n9jpRX87WsyonOA='
                    }
                ]
            }
        });

        startPeerBtn.addEventListener('click', async () => {
            try {
                peer = new Peer({
                    // host: 'pm-app.test',
                    // port: 9000,
                    // path: '/peerjs',
                    secure: true, // Changed to false to avoid HTTPS issues
                    debug: 3,
                    config: {
                        'iceServers': [{
                                urls: 'stun:stun.l.google.com:19302'
                            },
                            {
                                urls: 'stun:stun1.l.google.com:19302'
                            },
                            {
                                urls: 'turn:relay1.expressturn.com:3480',
                                username: '000000002063784502',
                                credential: 'yJNV6kn+ZsS9n9jpRX87WsyonOA='
                            }
                        ]
                    }
                });

                peer.on('open', id => {
                    statusText.textContent = 'Open';
                    peerIdText.textContent = id;

                    if (localStream) {
                        localVideo.srcObject = localStream;
                    } else {
                        alert('Camera is not active. Please turn on the camera first.');
                    }

                    // Send peer_id to the server
                    fetch('/store-peer-id', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            peer_id: id
                        })
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to store peer_id');
                        }
                        return response.json();
                    }).then(data => {
                        console.log('Peer ID stored successfully:', data);
                    }).catch(error => {
                        console.error('Error storing peer_id:', error);
                    });
                });



            } catch (err) {
                peer.on('error', err => {
                    statusText.textContent = 'Error: ' + err.type;
                });

                console.error('Error starting peer connection:', err);
                alert('Failed to start peer connection: ' + err.message);
            }
        });

        endPeerBtn.addEventListener('click', () => {
            try {
                if (peer && !peer.destroyed) {
                    peer.destroy();
                    statusText.textContent = 'Disconnected';

                    if (localStream) {
                        localStream.getTracks().forEach(track => track.stop());
                        localVideo.srcObject = null;
                        cameraOn = false;
                    }

                    // Update status to 'end' and set end time
                    fetch('/update-peer-session', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            status: 'end',
                            end: new Date().toISOString(),
                            peer_id: peerIdText.textContent
                        })
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to update status');
                        }
                        return response.json();
                    }).then(data => {
                        console.log('Status updated successfully:', data);
                    }).catch(error => {
                        console.error('Error updating status:', error);
                    });

                } else {
                    alert('Peer connection is not active or has already been destroyed.');
                }
            } catch (err) {
                console.error('Error ending peer connection:', err);
                alert('Failed to end peer connection: ' + err.message);
            }
        });

        peer.on('disconnected', () => {
            statusText.textContent = 'Disconnected';
        });

        // peer.on('call', call => {
        //     console.log('Incoming call from:', call.peer);

        //     const answerWithStream = (stream) => {
        //         call.answer(stream);
        //         console.log('Answered call with stream.');
        //     };

        //     if (localStream) {
        //         answerWithStream(localStream);
        //     } else {
        //         navigator.mediaDevices.getUserMedia({
        //             video: true,
        //             audio: false
        //         }).then(stream => {
        //             localStream = stream;
        //             localVideo.srcObject = stream;
        //             answerWithStream(stream);
        //         }).catch(err => {
        //             console.error('Gagal mengakses kamera:', err);
        //         });
        //     }
        // });

        peer.on('call', call => {
            console.log('Incoming call from:', call.peer);
            if (localStream) {
                call.answer(localStream);
            } else {
                navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: true
                }).then(stream => {
                    localStream = stream;
                    localVideo.srcObject = localStream;
                    call.answer(localStream);
                });
            }
        });

        // peer.on('call', call => {
        //     log('Incoming call from:', call.peer);
        //     if (localStream) {
        //         call.answer(localStream);
        //     } else {
        //         navigator.mediaDevices.getUserMedia({
        //             video: true,
        //             audio: false
        //         }).then(stream => {
        //             localStream = stream;
        //             localVideo.srcObject = localStream;
        //             call.answer(localStream);
        //         });
        //     }
        // });
    </script>
</div>
