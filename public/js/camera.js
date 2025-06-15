// const localVideo = document.getElementById('localVideo');
// const remoteVideo = document.getElementById('remoteVideo');

// let localStream;
// let peer;
// let call;

// // Ganti dengan ID unik untuk setiap user, misal dari backend atau prompt
const myPeerId = 'user1';
const remotePeerId = 'user2';

document.querySelector('#showVideo').addEventListener('click', async () => {
    if (!localStream) {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        localVideo.srcObject = localStream;

        // Inisialisasi PeerJS
        peer = new Peer(myPeerId);

        peer.on('open', id => {
            // Jika ingin memanggil user lain
            call = peer.call(remotePeerId, localStream);
            call.on('stream', remoteStream => {
                remoteVideo.srcObject = remoteStream;
            });
        });

        peer.on('call', incomingCall => {
            // Jawab panggilan masuk
            incomingCall.answer(localStream);
            incomingCall.on('stream', remoteStream => {
                remoteVideo.srcObject = remoteStream;
            });
            call = incomingCall;
        });
    } else {
        hangup();
    }
});

function hangup() {
    if (call) {
        call.close();
        call = null;
    }
    if (peer) {
        peer.destroy();
        peer = null;
    }
    if (localStream) {
        localStream.getTracks().forEach(track => track.stop());
        localStream = null;
    }
    localVideo.srcObject = null;
    remoteVideo.srcObject = null;
}



// const localVideo = document.getElementById('localVideo');
// const remoteVideo = document.getElementById('remoteVideo');

// let pc;
// let localStream;
// let isSender = false;

// const receiverId = 2; // ID user yang akan menerima sinyal
// const userId = 1; // ID user saat ini (autentikasi login)

// // Tombol start
// document.querySelector('#showVideo').addEventListener('click', async () => {
//     if (!isSender) {
//         localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
//         localVideo.srcObject = localStream;
//         isSender = true;
//         sendSignal('ready', null);
//     } else {
//         hangup();
//         sendSignal('bye', null);
//         isSender = false;
//     }
// });

// // Laravel Echo subscribe
// window.Echo.private(`webrtc.${userId}`)
//     .listen('WebRTCSignalEvent', async (e) => {
//         const data = e.message;

//         if (data.type === 'ready' && isSender && !pc) {
//             await makeCall();
//         } else if (data.type === 'offer' && !isSender) {
//             await handleOffer(data);
//         } else if (data.type === 'answer' && isSender) {
//             await handleAnswer(data);
//         } else if (data.type === 'candidate') {
//             await handleCandidate(data);
//         } else if (data.type === 'bye') {
//             hangup();
//         }
//     });

// // Fungsi signaling kirim ke server
// function sendSignal(type, data) {
//     fetch('/api/webrtc/signal', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify({
//             receiver_id: receiverId,
//             message: Object.assign({ type }, data || {})
//         })
//     });
// }

// // Signaling functions
// async function makeCall() {
//     createPeerConnection();
//     localStream.getTracks().forEach(track => pc.addTrack(track, localStream));
//     const offer = await pc.createOffer();
//     await pc.setLocalDescription(offer);
//     sendSignal('offer', { sdp: offer.sdp });
// }

// async function handleOffer(offer) {
//     if (pc) return;
//     createPeerConnection();
//     await pc.setRemoteDescription({ type: 'offer', sdp: offer.sdp });
//     const answer = await pc.createAnswer();
//     await pc.setLocalDescription(answer);
//     sendSignal('answer', { sdp: answer.sdp });
// }

// async function handleAnswer(answer) {
//     if (!pc) return;
//     await pc.setRemoteDescription({ type: 'answer', sdp: answer.sdp });
// }

// async function handleCandidate(data) {
//     if (!pc) return;
//     if (data.candidate) {
//         await pc.addIceCandidate(new RTCIceCandidate(data.candidate));
//     }
// }

// function createPeerConnection() {
//     pc = new RTCPeerConnection();

//     pc.onicecandidate = e => {
//         if (e.candidate) {
//             sendSignal('candidate', { candidate: e.candidate });
//         }
//     };

//     pc.ontrack = e => {
//         remoteVideo.srcObject = e.streams[0];
//     };
// }

// function hangup() {
//     if (pc) {
//         pc.close();
//         pc = null;
//     }
//     if (localStream) {
//         localStream.getTracks().forEach(track => track.stop());
//         localStream = null;
//     }
//     localVideo.srcObject = null;
//     remoteVideo.srcObject = null;
// }


