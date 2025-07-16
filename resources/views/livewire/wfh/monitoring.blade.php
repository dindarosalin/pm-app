<div>
    @section('title', 'Monitoring')
    {{-- <video id="video-remote" autoplay playsinline style="width: 400px;"></video> --}}



    <div id="remote-container" wire:ignore class="row g-3">
        {{-- Video remote akan muncul di sini --}}
    </div>
    <div id="empty-state" class="text-center text-muted mt-4" ">
        <i class="bi bi-person-x" style="font-size: 3rem;"></i>
        <p class="mt-2">Tidak ada karyawan yang sedang online.</p>
    </div>
    <button class="btn btn-success" id="call-btn" hidden>Panggil</button>

    @push('scripts')
    <script>
        window.targetPeerIds = @json($peerIds);
        window.statusMap = @json($statusList);
        const calledPeers = new Set();


        // Event listener untuk menerima event dari Livewire
        // window.addEventListener('refreshMonitoring', function() {
        //     if (window.Livewire) {
        //         Livewire.dispatch('refreshMonitoring');
        //     }
        // });
    </script>

            {{-- <script type="module">
            import {
                Peer
            } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

            const targetPeerIds = window.targetPeerIds ?? [];
            const peer = new Peer({
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

            // Stream kosong untuk call
            function getBlankStream() {
                const canvas = document.createElement('canvas');
                canvas.width = 640;
                canvas.height = 480;
                const ctx = canvas.getContext('2d');
                ctx.fillStyle = 'black';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                return canvas.captureStream(15);
            }

            function getSilentMediaStream() {
                const ctx = new AudioContext();
                const oscillator = ctx.createOscillator();
                const dst = oscillator.connect(ctx.createMediaStreamDestination());
                oscillator.start();
                const stream = dst.stream;
                return stream;
            }


            // Buat video card
            function createVideoCard(peerId, remoteStream) {
                const container = document.getElementById('remote-container');
                if (document.getElementById(`remote-card-${peerId}`)) return;

                const col = document.createElement('div');
                col.className = 'col-md-6 col-lg-4';
                col.id = `remote-card-${peerId}`;

                const card = document.createElement('div');
                card.className = 'card shadow rounded-3 position-relative';

                const overlay = document.createElement('div');
                overlay.id = `status-overlay-${peerId}`;
                overlay.className = 'position-absolute top-0 start-0 bg-dark bg-opacity-75 text-white px-2 py-1 rounded-end';
                overlay.style.zIndex = '10';
                overlay.style.fontSize = '0.8rem';
                overlay.textContent = 'Status: -';

                const body = document.createElement('div');
                body.className = 'card-body';

                const title = document.createElement('h6');
                title.className = 'card-title text-muted small';
                title.textContent = `Peer ID: ${peerId}`;

                const video = document.createElement('video');
                video.id = `remote-video-${peerId}`;
                video.className = 'w-100 rounded';
                video.autoplay = true;
                video.playsInline = true;
                video.srcObject = remoteStream;

                body.appendChild(title);
                body.appendChild(video);
                // card.appendChild(overlay);
                card.appendChild(body);
                col.appendChild(card);
                container.appendChild(col);
            }

            // Panggil dan koneksi ke semua peer
            function callAllPeers() {
                const stream = getBlankStream();
                // const stream = getSilentMediaStream();


                targetPeerIds.forEach(peerId => {
                    // 1. Call video
                    const call = peer.call(peerId, stream);
                    call.on('stream', remoteStream => {
                        createVideoCard(peerId, remoteStream);
                    });
                });
            }

            // Tombol manual
            document.getElementById('call-btn').addEventListener('click', callAllPeers);

            peer.on('open', function(id) {
                console.log('Admin peer ID:', id);
                setTimeout(() => {
                    callAllPeers();
                }, 0); // panggil langsung
            });
        </script> --}}

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

                let existingPeers = [...targetPeerId]; // dari backend

                async function pollPeerIds() {
                    try {
                        const res = await fetch('/api/peer-ids');
                        const peerIds = await res.json();

                        const newPeers = peerIds.filter(id => !existingPeers.includes(id));
                        newPeers.forEach(peerId => {
                            existingPeers.push(peerId);
                            console.log('Peer baru ditemukan:', peerId);
                            callPeerById(peerId);
                        });



                        // 🚨 Hapus peer yang tidak aktif
                        const removedPeers = existingPeers.filter(id => !peerIds.includes(id));
                        removedPeers.forEach(peerId => {
                            console.log('Peer tidak aktif, hapus:', peerId);
                            const el = document.getElementById(`remote-card-${peerId}`);
                            if (el) el.remove();
                        });

                        // Perbarui list existing dengan yang aktif saja
                        existingPeers = peerIds;

                        // Perbarui list existing dengan yang aktif saja
                        existingPeers = peerIds;

                        // 🔽 Tampilkan atau sembunyikan empty state
                        const emptyState = document.getElementById('empty-state');
                        if (peerIds.length === 0) {
                            emptyState.style.display = 'block';
                        } else {
                            emptyState.style.display = 'none';
                        }

                    } catch (error) {
                        console.error('Gagal polling peer:', error);
                    }
                }

                setInterval(pollPeerIds, 3000); // ⏱ Jalankan setiap 3 detik

                function callPeerById(peerId) {
                    const canvas = document.createElement('canvas');
                    canvas.width = 640;
                    canvas.height = 480;
                    const ctx = canvas.getContext('2d');
                    ctx.fillStyle = 'black';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    const stream = canvas.captureStream(15);

                    const call = peer.call(peerId, stream);
                    call.on('stream', (remoteStream) => {
                        const container = document.getElementById('remote-container');
                        const existingCard = document.getElementById(`remote-card-${peerId}`);

                        if (!existingCard && container) {
                            const cardCol = document.createElement('div');
                            cardCol.className = 'col-md-6 col-lg-4';
                            cardCol.id = `remote-card-${peerId}`;

                            const card = document.createElement('div');
                            card.className = 'card shadow rounded-3';

                            const cardBody = document.createElement('div');
                            cardBody.className = 'card-body';

                            const overlay = document.createElement('div');
                            overlay.id = `status-overlay-${peerId}`;
                            overlay.className =
                                'position-absolute top-0 start-0 bg-dark bg-opacity-75 text-white px-2 py-1 rounded-end';
                            overlay.style.zIndex = '10';
                            overlay.style.fontSize = '0.8rem';
                            overlay.textContent = 'Status: -';

                            const title = document.createElement('h6');
                            title.className = 'card-title text-muted small';
                            title.textContent = `Peer ID: ${peerId}`;

                            const aspectWrapper = document.createElement('div');
                            aspectWrapper.style.position = 'relative';
                            aspectWrapper.style.width = '100%';
                            aspectWrapper.style.paddingTop = '56.25%'; // 16:9 aspect ratio

                            const video = document.createElement('video');
                            video.id = `remote-video-${peerId}`;
                            video.autoplay = true;
                            video.playsInline = true;
                            video.controls = false;
                            video.className = 'rounded';
                            video.style.position = 'absolute';
                            video.style.top = 0;
                            video.style.left = 0;
                            video.style.width = '100%';
                            video.style.height = '100%';
                            video.style.objectFit = 'cover'; // Atau 'contain' jika ingin menyesuaikan video

                            video.srcObject = remoteStream;

                            aspectWrapper.appendChild(video);
                            cardBody.appendChild(title);
                            cardBody.appendChild(aspectWrapper);

                            cardBody.appendChild(title);
                            cardBody.appendChild(video);
                            card.appendChild(overlay);
                            card.appendChild(cardBody);
                            cardCol.appendChild(card);
                            container.appendChild(cardCol);
                        }
                    });

                    const dataConn = peer.connect(peerId);
                    dataConn.on('open', () => {
                        dataConn.on('data', (data) => {
                            const statusEl = document.getElementById(`status-overlay-${peerId}`);
                            if (statusEl && data.status) {
                                const statusName = window.statusMap?.[data.status] ?? `Status ID: ${data.status}`;
                                statusEl.textContent = `Status: ${statusName}`;
                            }
                        });
                    });
                }

                //=============================================

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

                                const overlay = document.createElement('div');
                                overlay.id = `status-overlay-${peerId}`;
                                overlay.className =
                                    'position-absolute top-0 start-0 bg-dark bg-opacity-75 text-white px-2 py-1 rounded-end';
                                overlay.style.zIndex = '10';
                                overlay.style.fontSize = '0.8rem';
                                overlay.textContent = 'Status: -';

                                // Judul atau peer ID
                                const title = document.createElement('h6');
                                title.className = 'card-title text-muted small';
                                title.textContent = `Peer ID: ${peerId}`;

                                // Video element
                                const aspectWrapper = document.createElement('div');
                                aspectWrapper.style.position = 'relative';
                                aspectWrapper.style.width = '100%';
                                aspectWrapper.style.paddingTop = '56.25%'; // 16:9 aspect ratio

                                const video = document.createElement('video');
                                video.id = `remote-video-${peerId}`;
                                video.autoplay = true;
                                video.playsInline = true;
                                video.controls = false;
                                video.className = 'rounded';
                                video.style.position = 'absolute';
                                video.style.top = 0;
                                video.style.left = 0;
                                video.style.width = '100%';
                                video.style.height = '100%';
                                video.style.objectFit = 'cover'; // Atau 'contain' jika ingin menyesuaikan video

                                video.srcObject = remoteStream;

                                aspectWrapper.appendChild(video);
                                cardBody.appendChild(title);
                                cardBody.appendChild(aspectWrapper);

                                // Gabungkan elemen
                                cardBody.appendChild(title);
                                cardBody.appendChild(video);
                                card.appendChild(overlay);
                                card.appendChild(cardBody);
                                cardCol.appendChild(card);

                                // Tambahkan ke container
                                container.appendChild(cardCol);
                            }
                        });

                        const dataConn = peer.connect(peerId);
                        dataConn.on('open', () => {
                            dataConn.on('data', (data) => {
                                const statusEl = document.getElementById(`status-overlay-${peerId}`);
                                if (statusEl && data.status) {
                                    const statusName = window.statusMap?.[data.status] ??
                                        `Status ID: ${data.status}`;
                                    statusEl.textContent = `Status: ${statusName}`;
                                    // statusEl.textContent = `Status: ${data.status}`;
                                }
                            });
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


            {{-- PeerJS untuk panggilan video --}}
            {{-- https://peerjs.com/docs/ --}}
            {{--  
        <script type="module">
            // import {
            //     Peer
            // } from "https://esm.sh/peerjs@1.5.4?bundle-deps";

            // // PeerID tujuan 
            // // const targetPeerId = ['04d7d953-b605-46d1-a67c-777a560ac5b2'];

            // const targetPeerId = window.targetPeerIds ?? [];
            // console.log("Peer IDs from backend:", targetPeerId);

            // // Buat peer tanpa ID
            // const peer = new Peer({
            //     // host: 'pm-app.test',
            //     // port: 9000,
            //     // path: '/peerjs',
            //     secure: true,
            //     debug: 3,
            //     config: {
            //         'iceServers': [{
            //                 urls: 'stun:stun.l.google.com:19302'
            //             },
            //             {
            //                 urls: 'stun:stun1.l.google.com:19302'
            //             },
            //             {
            //                 urls: 'turn:relay1.expressturn.com:3480',
            //                 username: '000000002063784502',
            //                 credential: 'yJNV6kn+ZsS9n9jpRX87WsyonOA='
            //             }
            //         ]
            //     }
            // });

            // // Fungsi untuk melakukan panggilan ke peer lain
            // async function callPeer() {

            //     // Membuat stream video kosong (black video)
            //     const canvas = document.createElement('canvas');
            //     canvas.width = 640;
            //     canvas.height = 480;
            //     const ctx = canvas.getContext('2d');
            //     ctx.fillStyle = 'black';
            //     ctx.fillRect(0, 0, canvas.width, canvas.height);
            //     const stream = canvas.captureStream(15); // 15 fps

            //     // Loop
            //     targetPeerId.forEach(peerId => {
            //         // Panggil peer dengan stream video kosong
            //         console.log(`Calling peer: ${peerId}`);

            //         // Kirim stream video kosong ke peer
            //         const call = peer.call(peerId, stream);


            //         call.on('stream', function(remoteStream) {
            //             const container = document.getElementById('remote-container');
            //             const existingCard = document.getElementById(`remote-card-${peerId}`);

            //             if (!existingCard && container) {
            //                 // Card container
            //                 const cardCol = document.createElement('div');
            //                 cardCol.className = 'col-md-6 col-lg-4';
            //                 cardCol.id = `remote-card-${peerId}`;

            //                 // Bootstrap Card
            //                 const card = document.createElement('div');
            //                 card.className = 'card shadow rounded-3';

            //                 const cardBody = document.createElement('div');
            //                 cardBody.className = 'card-body';

            //                 // Judul atau peer ID
            //                 const title = document.createElement('h6');
            //                 title.className = 'card-title text-muted small';
            //                 title.textContent = `Peer ID: ${peerId}`;

            //                 // Video element
            //                 const video = document.createElement('video');
            //                 video.id = `remote-video-${peerId}`;
            //                 video.autoplay = true;
            //                 video.playsInline = true;
            //                 video.controls = false;
            //                 video.className = 'w-100 rounded';
            //                 video.srcObject = remoteStream;

            //                 // Gabungkan elemen
            //                 cardBody.appendChild(title);
            //                 cardBody.appendChild(video);
            //                 card.appendChild(cardBody);
            //                 cardCol.appendChild(card);

            //                 // Tambahkan ke container
            //                 container.appendChild(cardCol);
            //             }
            //         });

            //     });
            // }

            // // Tombol untuk memulai panggilan
            // document.getElementById('call-btn').addEventListener('click', callPeer);

            // peer.on('open', function(id) {
            //     console.log('Peer connected with ID:', id);
            //     setTimeout(() => {
            //         callPeer();
            //     }, 0);
            // });
        </script>
        --}}
@endpush
</div>
