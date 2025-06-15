<div>
    <div id="monitoring-video-container"></div>
    <video id="video-remote" autoplay playsinline style="width: 400px;"></video>
    <button id="call-btn">Panggil Peer</button>

    @push('scripts')
        <script type="module">
            import {
                Peer
            } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

            // PeerID tujuan (yang ingin Anda panggil)
            const targetPeerId = '017d8098-7280-4013-b939-25c3f6287f76';
            const container = document.getElementById('monitoring-video-container');

            // Buat peer tanpa ID (biar dapat random ID)
            const peer = new Peer({
                host: 'pm-app.test',
                port: 9000,
                path: '/peerjs',
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

            // Fungsi untuk mengambil data peer_id dengan status ongoing
            async function fetchOngoingPeerIds() {
                try {
                    const response = await fetch('/ongoing-peer-ids');
                    if (!response.ok) {
                        throw new Error('Failed to fetch ongoing peer IDs');
                    }
                    const data = await response.json();
                    console.log('Ongoing peer IDs:', data.peer_ids);
                    return data.peer_ids;
                } catch (error) {
                    console.error('Error fetching ongoing peer IDs:', error);
                    return [];
                }
            }

            // Fungsi untuk melakukan panggilan ke peer lain
            // async function callPeers() {
            //     const peerIds = await fetchOngoingPeerIds();
            //     console.log('Calling peers:', peerIds);

            //     // Membuat stream video kosong (black video)
            //     const canvas = document.createElement('canvas');
            //     canvas.width = 640;
            //     canvas.height = 480;
            //     const ctx = canvas.getContext('2d');
            //     ctx.fillStyle = 'black';
            //     ctx.fillRect(0, 0, canvas.width, canvas.height);
            //     const stream = canvas.captureStream(15); // 15 fps

            // Kirim stream video kosong ke peer
            // peerIds.forEach(targetPeerId => {
            //     console.log('Calling peer:', targetPeerId);

            //     const call = peer.call(targetPeerId, stream);

            //     call.on('stream', function(remoteStream) {
            //         console.log('Received remoteStream from:', targetPeerId);

            //     });


            // });
            //     peerIds.forEach(peerId => {
            //         const call = peer.call(peerId, stream);
            //         call.answer(stream);
            //         call.on('stream', function(remoteStream) {
            //             console.log('Received remoteStream:', remoteStream);
            //             const video = document.getElementById(`video-${peerId}`) || document.createElement(
            //                 'video');
            //             video.id = `video-${peerId}`;
            //             video.autoplay = true;
            //             video.playsInline = true;
            //             video.style.width = '400px';
            //             video.srcObject = remoteStream;
            //             if (!document.getElementById(`video-${peerId}`)) {
            //                 document.getElementById('monitoring-video-container').appendChild(video);
            //             }
            //             video.play();
            //         });
            //         call.on('error', error => console.error(`Error with call to peer: ${peerId}`, error));
            //     });
            // }

            // Tombol untuk memulai panggilan
            // document.getElementById('call-btn').addEventListener('click', callPeers);

            // Polling untuk memperbarui peer IDs setiap 5 detik
            // setInterval(callPeers, 5000);

            // Memulai panggilan otomatis saat halaman dimuat



            // Fungsi untuk melakukan panggilan ke peer lain
            async function callPeer() {
                const targetPeerIds = await fetchOngoingPeerIds();
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
                    console.log('Received remoteStream:', remoteStream);
                    const video = document.getElementById('video-remote');
                    if (video) {
                        video.srcObject = remoteStream;
                        video.play();
                    }
                });
            }

            // Tombol untuk memulai panggilan
            document.getElementById('call-btn').addEventListener('click', callPeer);
            callPeer();
        </script>
    @endpush
</div>
