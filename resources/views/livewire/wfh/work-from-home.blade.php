<div>
    @section('title', 'Work From Home')

    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="row">
                <div class="col-md-8 mt-3 position-relative">
                    <video id="localVideo" autoplay playsinline muted></video>
                    <button id="toggleCameraBtn">Open camer a</button>
                    <div class="text-center mt-2"></div>
                    <div id="peerStatus">Status: <span id="peerStatusText">Connecting...</span></div>
                    <div>ID: <span id="peerIdText">-</span></div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <select class="form-select form-select-md mt-4" name="" id="statusWfh">
                            <option selected>Select status</option>
                            @foreach ($statusList as $status)
                                <option value="{{ $status->id }}">{{ $status->status_wfh }}</option>
                            @endforeach
                            {{-- <option value="">Master 1</option>
                            <option value="">Master 2</option>
                            <option value="">Master 3</option> --}}
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


    {{-- <script type="module">
        import {
            Peer
        } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

        document.getElementById('startPeerBtn').addEventListener('click', () => {
            document.getElementById('peerStatusText').textContent = 'Connecting...';
            document.getElementById('peerIdText').textContent = '-';
            startPeerConnection();
        });

        document.getElementById('endPeerBtn').addEventListener('click', () => {
            if (peer) {
                peer.destroy();
                document.getElementById('peerStatusText').textContent = 'Disconnected';
                document.getElementById('peerIdText').textContent = '-';
            }
        });

        startPeerConnection = () => {
            if (peer) {
                peer.destroy();
            }
            document.getElementById('localVideo').srcObject = null;
            document.getElementById('peerStatusText').textContent = 'Connecting...';
            document.getElementById('peerIdText').textContent = '-';
        };





        const peer = new Peer({
            // host: 'pm-app.test',
            // port: 9000,
            // path: '/peerjs',
            secure: true,
            debug: 0,
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

        let localStream = null;
        const localVideo = document.getElementById('localVideo');
        const statusText = document.getElementById('peerStatusText');
        const peerIdText = document.getElementById('peerIdText');

        peer.on('open', async id => {
            statusText.textContent = 'Open';
            peerIdText.textContent = id;
            localStream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            });
            localVideo.srcObject = localStream;
        });

        peer.on('error', err => {
            statusText.textContent = 'Error: ' + err.type;
        });

        peer.on('disconnected', () => {
            statusText.textContent = 'Disconnected';
        });

        peer.on('close', () => {
            statusText.textContent = 'Closed';
        });

        peer.on('call', call => {
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
    </script> --}}

    {{-- Bisa start dan end button --}}
    {{-- <script type="module">
        import { Peer } from "https://esm.sh/peerjs@1.5.4?bundle-deps";
    
        let peer = null;
        let localStream = null;
    
        const localVideo = document.getElementById('localVideo');
        const statusText = document.getElementById('peerStatusText');
        const peerIdText = document.getElementById('peerIdText');
    
        const startPeerConnection = async () => {
            // Jika peer sudah ada, destroy dulu
            if (peer) {
                peer.destroy();
                peer = null;
            }
    
            // Kosongkan video dan status
            localVideo.srcObject = null;
            statusText.textContent = 'Connecting...';
            peerIdText.textContent = '-';
    
            try {
                // Buat ulang peer
                peer = new Peer({
                    secure: true,
                    debug: 0,
                    config: {
                        'iceServers': [
                            { urls: 'stun:stun.l.google.com:19302' },
                            { urls: 'stun:stun1.l.google.com:19302' },
                            {
                                urls: 'turn:relay1.expressturn.com:3480',
                                username: '000000002063784502',
                                credential: 'yJNV6kn+ZsS9n9jpRX87WsyonOA='
                            }
                        ]
                    }
                });
    
                // Saat koneksi berhasil
                peer.on('open', async id => {
                    statusText.textContent = 'Open';
                    peerIdText.textContent = id;
    
                    localStream = await navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: true
                    });
                    localVideo.srcObject = localStream;
                });
    
                // Error handling
                peer.on('error', err => {
                    statusText.textContent = 'Error: ' + err.type;
                });
    
                peer.on('disconnected', () => {
                    statusText.textContent = 'Disconnected';
                });
    
                peer.on('close', () => {
                    statusText.textContent = 'Closed';
                });
    
                // Saat ada call masuk
                peer.on('call', call => {
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
    
            } catch (error) {
                statusText.textContent = 'Error: ' + error.message;
            }
        };
    
        const endPeerConnection = () => {
            if (peer) {
                peer.destroy();
                peer = null;
                statusText.textContent = 'Disconnected';
                peerIdText.textContent = '-';
                localVideo.srcObject = null;
            }
        };
    
        // Tombol Start dan End
        document.getElementById('startPeerBtn').addEventListener('click', startPeerConnection);
        document.getElementById('endPeerBtn').addEventListener('click', endPeerConnection);
    </script> --}}

    <script type="module">
        import {
            Peer
        } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

        let peer = null;
        let localStream = null;
        let isCameraOn = false;
        let currentPeerId = null;
        let conn = null; // global untuk komunikasi data (status)

        const localVideo = document.getElementById('localVideo');
        const statusText = document.getElementById('peerStatusText');
        const peerIdText = document.getElementById('peerIdText');
        const toggleCameraBtn = document.getElementById('toggleCameraBtn');

        // Fungsi menyalakan kamera
        async function enableCamera() {
            if (!localStream) {
                localStream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                });
            }
            localVideo.srcObject = localStream;
            isCameraOn = true;
            toggleCameraBtn.textContent = 'Off Camera';
        }

        // Fungsi mematikan kamera tanpa memutus koneksi peer
        function disableCamera() {
            if (localStream) {
                localStream.getTracks().forEach(track => {
                    if (track.kind === 'video') track.stop();
                });
            }
            localVideo.srcObject = null;
            isCameraOn = false;
            toggleCameraBtn.textContent = 'Open Camera';
        }

        toggleCameraBtn.addEventListener('click', async () => {
            if (isCameraOn) {
                disableCamera();
            } else {
                await enableCamera();
            }
        });

        // Start Peer + kirim peerId ke server
        async function startPeerConnection() {
            if (peer) peer.destroy();

            statusText.textContent = 'Connecting...';
            peerIdText.textContent = '-';

            peer = new Peer({
                secure: true,
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


            peer.on('open', async id => {
                statusText.textContent = 'Open';
                peerIdText.textContent = id;
                currentPeerId = id;

                await enableCamera(); // nyalakan kamera saat koneksi terbuka

                // Kirim ke backend (ubah URL sesuai Laravel route-mu)
                fetch('/store-peer-id', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        peer_id: id,
                        status: 'connected'
                    })
                });
            });

            // Get status WFH dari select
            peer.on('connection', (connection) => {
                conn = connection;

                conn.on('open', () => {
                    console.log('DataConnection opened from admin');

                    // Optional: kirim status saat terkoneksi
                    const select = document.getElementById('statusWfh');
                    if (select && select.value !== 'Select status') {
                        conn.send({
                            status: select.value
                        });
                    }

                    // Saat status dipilih (employee ubah select)
                    document.getElementById('statusWfh').addEventListener('change', (e) => {
                        const newStatus = e.target.value;
                        if (conn && conn.open) {
                            conn.send({
                                status: newStatus
                            });
                        }
                    });
                });

                conn.on('data', (data) => {
                    console.log("Received from admin:", data);
                    // Bisa dipakai jika admin ingin kirim instruksi
                });
            });

            peer.on('error', err => {
                statusText.textContent = 'Error: ' + err.type;
            });

            peer.on('disconnected', () => {
                statusText.textContent = 'Disconnected';
            });

            peer.on('close', () => {
                statusText.textContent = 'Closed';
            });

            peer.on('call', call => {
                if (localStream) {
                    call.answer(localStream);
                } else {
                    navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: false
                    }).then(stream => {
                        localStream = stream;
                        localVideo.srcObject = localStream;
                        call.answer(localStream);
                    });
                }
            });
        }

        // End Peer + kirim info ke backend
        function endPeerConnection() {
            if (peer) {
                peer.destroy();
                peer = null;
                peerIdText.textContent = '-';
                statusText.textContent = 'Disconnected';

                // Matikan kamera
                disableCamera();

                // Kirim ke backend (ubah URL sesuai Laravel route)
                fetch('/update-peer-session', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        peer_id: currentPeerId,
                        session_status: 'end'
                    })
                });
            }
        }


        // Button Event
        document.getElementById('startPeerBtn').addEventListener('click', startPeerConnection);
        document.getElementById('endPeerBtn').addEventListener('click', endPeerConnection);
    </script>


</div>
