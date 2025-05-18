<div>
    <!-- Modal -->
    <div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailModalLabel">Modal Title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @if($selectedCuti)
                        <p><strong>Jenis Cuti:</strong> {{ $selectedCuti->cuti_name }}</p>
                        <p><strong>Tanggal Pengajuan:</strong> {{ $selectedCuti->tanggal_pengajuan }}</p>
                        
                    {{-- @else
                        <p>Data tidak tersedia.</p> --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>