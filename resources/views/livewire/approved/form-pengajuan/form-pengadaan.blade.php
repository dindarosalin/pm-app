<div>
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="pengadaanForm" 
        aria-labelledby="pengadaanFormLabel" data-bs-scroll="true" data-bs-backdrop="static">
        <div class="offcanvas-header bg-success text-white">
            <h5 id="pengadaanLabel">
                {{ $pengadaanId ? 'Edit Pengajuan Pengadaan' : 'Buat Pengajuan Pengadaan' }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" 
                aria-label="Close" wire:click="btnCloseOffcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                <div class="mb-3">
                    <label class="form-label">Nama Proyek</label>
                    <input type="text" wire:model="nama_proyek" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kode Dokumen</label>
                    <input type="text" wire:model="kode_dokumen" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pengajuan</label>
                    <input type="date" wire:model="tanggal_ajuan" class="form-control form-control-sm"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Departement</label>
                    <select wire:model="id_department" class="form-select form-select-sm">
                        <option value="">Pilih Departement</option>
                        @foreach ($departments as $item)
                            <option value="{{ $item->id }}">{{ $item->job }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Pemohon</label>
                    <input type="text" wire:model="nama_pemohon" class="form-control form-control-sm">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" wire:model="lokasi" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ditujukan Kepada</label>
                    <input type="text" wire:model="ditujukan" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Persetujuan</label>
                    <input type="date" wire:model="tanggal_setuju" class="form-control form-control-sm"
                        required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="store">Simpan</span>
                        <span wire:loading wire:target="store">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
        </div>
    </div>
</div>
