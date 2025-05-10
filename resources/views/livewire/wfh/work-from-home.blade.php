<div>
    @section('title')
        Work From Home
    @endsection
    <div class="col-xl-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="row">
                <div class="col-md-8 mt-3 position-relative">
                    <video id="localVideo" autoplay muted playsinline class="w-full rounded-xl" style="width: 100%; height:auto"></video>
                    <div class="text-center mt-2">
                        <button id="toggleCamera" class="btn btn-warning">
                            <i id="cameraIcon" class="fas fa-video"></i> Camera
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <select class="form-select form-select-md mt-4" name="" id="">
                            <option selected>Select status</option>
                            <option value="">Master 1</option>
                            <option value="">Master 2</option>
                            <option value="">Master 3</option>
                        </select>
                    </div>

                    <div class="vstack gap-3">
                        <button type="button" class="btn btn-success col-12">Start</button>
                        <button type="button" class="btn btn-danger col-12">End</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>Today</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>This week</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>This month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="text-center">
                        <h2 class="p-2">00</h2>
                        <p>Performance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        let stream = null;
        const videoElement = document.getElementById('localVideo');
        const toggleButton = document.getElementById('toggleCamera');
        const cameraIcon = toggleButton.querySelector('i');
        let cameraActive = false;

        const startCamera = async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        aspectRatio: 16 / 9
                    },
                });

                videoElement.srcObject = stream;
                cameraActive = true;
                cameraIcon.className = 'fas fa-video';
                // console.log('Camera started.');
            } catch (error) {
                console.error('Error accessing media devices.', error);
                alert('Camera access was denied or not available.');
            }
        };

        const stopCamera = () => {
            if (stream) {
                const videoTracks = stream.getVideoTracks();
                videoTracks.forEach(track => track.stop());
                videoElement.srcObject = null;
                stream = null;
                cameraActive = false;
                cameraIcon.className = 'fas fa-video-slash';
                // console.log('Camera stopped.');
            }
            // Set video element to display a black screen
            videoElement.srcObject = null;
            videoElement.style.backgroundColor = 'black';
            videoElement.style.width = '100%';
            videoElement.style.height = 'auto';
        };

        toggleButton.addEventListener('click', async () => {
            if (cameraActive) {
                stopCamera();
            } else {
                await startCamera();
            }
        });

        // Start the camera initially
        await startCamera();
    });
</script>
@endpush
