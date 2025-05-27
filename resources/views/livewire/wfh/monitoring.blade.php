<div wire:poll.10s>
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
                    }]
                }
            });


            const activeCalls = {};

            async function connectToPeer(peerId) {
                if (activeCalls[peerId]) return;

                const emptyStream = new MediaStream(); // stream kosong
                const call = peer.call(peerId, emptyStream);

                if (!call) {
                    console.error("Gagal memanggil peer:", peerId);
                    return;
                }

                activeCalls[peerId] = call;

                call.on('stream', (remoteStream) => {
                    const video = document.getElementById('video-' + peerId);
                    if (video) {
                        video.srcObject = remoteStream;
                        video.play();
                    }
                });

                call.on('close', () => delete activeCalls[peerId]);
                call.on('error', (err) => {
                    console.error('Call error:', err);
                    delete activeCalls[peerId];
                });
            }


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
