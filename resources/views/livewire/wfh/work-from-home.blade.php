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


    <script type="module">
        import {
            Peer
        } from "https://esm.sh/peerjs@1.5.4?bundle-deps";
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
    </script>
</div>
