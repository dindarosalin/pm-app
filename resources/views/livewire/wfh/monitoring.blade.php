<div>
    @section('title', 'Monitoring')
    {{-- <video id="video-remote" autoplay playsinline style="width: 400px;"></video> --}}

    <div id="remote-container" wire:ignore class="row g-3">
        {{-- Video remote akan muncul di sini --}}
    </div>
    <button class="btn btn-success" id="call-btn">Panggil</button>

    @push('scripts')
        <script>
            window.targetPeerIds = @json($peerIds);
        </script>
        <script type="module">
            import {
                Peer
            } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

            // PeerID tujuan 
            // const targetPeerId = ['04d7d953-b605-46d1-a67c-777a560ac5b2'];

            const targetPeerId = window.targetPeerIds ?? [];
            console.log("Peer IDs from backend:", targetPeerId);

            // Buat peer tanpa ID
            const peer = new Peer({
                // host: 'pm-app.test',
                // port: 9000,
                // path: '/peerjs',
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

                // Loop
                targetPeerId.forEach(peerId => {
                    // Panggil peer dengan stream video kosong
                    console.log(`Calling peer: ${peerId}`);

                    // Kirim stream video kosong ke peer
                    const call = peer.call(peerId, stream);


                    call.on('stream', function(remoteStream) {
                        const container = document.getElementById('remote-container');
                        const existingCard = document.getElementById(`remote-card-${peerId}`);

                        if (!existingCard && container) {
                            // Card container
                            const cardCol = document.createElement('div');
                            cardCol.className = 'col-md-6 col-lg-4';
                            cardCol.id = `remote-card-${peerId}`;

                            // Bootstrap Card
                            const card = document.createElement('div');
                            card.className = 'card shadow rounded-3';

                            const cardBody = document.createElement('div');
                            cardBody.className = 'card-body';

                            // Judul atau peer ID
                            const title = document.createElement('h6');
                            title.className = 'card-title text-muted small';
                            title.textContent = `Peer ID: ${peerId}`;

                            // Video element
                            const video = document.createElement('video');
                            video.id = `remote-video-${peerId}`;
                            video.autoplay = true;
                            video.playsInline = true;
                            video.controls = false;
                            video.className = 'w-100 rounded';
                            video.srcObject = remoteStream;

                            // Gabungkan elemen
                            cardBody.appendChild(title);
                            cardBody.appendChild(video);
                            card.appendChild(cardBody);
                            cardCol.appendChild(card);

                            // Tambahkan ke container
                            container.appendChild(cardCol);
                        }
                    });


                    // call.on('stream', function(remoteStream) {
                    //     const video = document.createElement('video');
                    //     video.id = `remote-video-${peerId}`;
                    //     video.autoplay = true;
                    //     video.playsInline = true;
                    //     video.srcObject = remoteStream;
                    //     document.body.appendChild(video);
                    //     // const video = document.getElementById('video-remote');
                    //     // if (video) {
                    //     //     video.srcObject = remoteStream;
                    //     //     video.play();
                    //     // }
                    // });
                });
            }

            // Tombol untuk memulai panggilan
            document.getElementById('call-btn').addEventListener('click', callPeer);

            peer.on('open', function(id) {
                console.log('Peer connected with ID:', id);
                setTimeout(() => {
                    callPeer();
                }, 0);
            });
        </script>
    @endpush
</div>
