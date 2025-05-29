<div>
    <video id="video-remote" autoplay playsinline style="width: 400px;"></video>
    <button id="call-btn">Panggil Peer</button>

    @push('scripts')
        <script type="module">
            import {
                Peer
            } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

            // PeerID tujuan (yang ingin Anda panggil)
            const targetPeerId = '272437fa-e2c8-4a99-b3f2-44c7cc15e0a1';

            // Buat peer tanpa ID (biar dapat random ID)
            const peer = new Peer({
                host: 'pm-app.test',
                port: 9000,
                path: '/peerjs',
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

            // Fungsi untuk melakukan panggilan ke peer lain
            async function callPeer() {
                // Membuat stream video kosong (black video)
                const canvas = document.createElement('canvas');
                canvas.width = 640;
                canvas.height = 480;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = 'black';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                const stream = canvas.captureStream(15); // 15 fps

                // Kirim stream video kosong ke peer
                const call = peer.call(targetPeerId, stream);

                call.on('stream', function(remoteStream) {
                    const video = document.getElementById('video-remote');
                    if (video) {
                        video.srcObject = remoteStream;
                        video.play();
                    }
                });
            }

            // Tombol untuk memulai panggilan
            document.getElementById('call-btn').addEventListener('click', callPeer);
        </script>
    @endpush
</div>
