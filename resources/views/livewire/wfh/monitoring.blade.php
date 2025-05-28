<div>
    @section('title', 'Monitoring Work From Home')

    @push('styles')
        <style>
            video {
                /* background: #222; */
                width: 100%;
                height: auto;
                margin-bottom: 1rem;
            }
        </style>
    @endpush

    <div class="row">
        @foreach ($sessions as $session)
            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h5>{{ $session->user_name }}</h5>
                    <span>{{ $session->peer_id }}</span>
                    <video id="video-{{ $session->peer_id }}" autoplay playsinline muted></video>
                </div>
            </div>
        @endforeach
    </div>

    @push('scripts')
        <script type="module">
            import {
                Peer
            } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

            const peer = new Peer({
                host: 'pm-app.test',
                port: 9000,
                path: '/peerjs',
                secure: true,
                debug: 3,
                config: {
                    'iceServers': [{
                            urls: 'stun:stun.l.google.com:19302'
                        }, // Existing STUN server
                        {
                            urls: 'stun:stun1.l.google.com:19302'
                        }, // Additional STUN server
                        {
                            urls: 'turn:relay1.expressturn.com:3480', // Replace with your TURN server
                            username: '000000002063784502', // Replace with your TURN server username
                            credential: 'yJNV6kn+ZsS9n9jpRX87WsyonOA=' // Replace with your TURN server password
                        }
                    ]
                }
            });


            const activeCalls = {};

            async function connectToPeer(peerId) {
                if (activeCalls[peerId]) return;

                console.log('[MONITORING] Attempting to call peer:', peerId);

                // Gunakan stream kosong
                const emptyStream = new MediaStream();
                const call = peer.call(peerId, emptyStream); // Kirim stream kosong

                if (!call) {
                    console.error('[MONITORING] Gagal memanggil peer:', peerId);
                    return;
                }

                activeCalls[peerId] = call;

                call.on('stream', (stream) => {
                    console.log('[MONITORING] Received remote stream from', peerId, stream);
                    const video = document.getElementById('video-' + peerId);
                    if (video) {
                        video.srcObject = stream;
                        video.play();
                        console.log('[MONITORING] Video element updated for', peerId);
                    } else {
                        console.warn('[MONITORING] Video element not found for', peerId);
                    }
                });

                call.on('close', () => {
                    console.log('[MONITORING] Call closed with', peerId);
                    delete activeCalls[peerId];
                });
                call.on('error', (err) => {
                    console.error('[MONITORING] Call error:', err);
                    delete activeCalls[peerId];
                });

                console.log('[MONITORING] Connected to peer:', peerId);
            }

            peer.on('call', (call) => {
                console.log('[MONITORING] Incoming call from:', call.peer);
                call.answer();
                call.on('stream', (remoteStream) => {
                    console.log('[MONITORING] Incoming stream from', call.peer, remoteStream);
                    const video = document.getElementById('video-' + call.peer);
                    if (video) {
                        video.srcObject = remoteStream;
                        video.play();
                        console.log('[MONITORING] Video element updated for', call.peer);
                    } else {
                        console.warn('[MONITORING] Video element not found for', call.peer);
                    }
                });
            });


            // Check every 5s if video is not playing yet
            setInterval(() => {
                document.querySelectorAll('video[id^="video-"]').forEach(video => {
                    const peerId = video.id.replace('video-', '');
                    if (!activeCalls[peerId]) {
                        connectToPeer(peerId);
                    }
                });
            }, 5000);
        </script>
    @endpush
</div>
