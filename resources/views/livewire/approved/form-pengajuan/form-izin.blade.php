<div>
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="izinForm" 
        aria-labelledby="cutiFormLabel" data-bs-scroll="true" data-bs-backdrop="static">

        <div class="offcanvas-header bg-success text-white">
            <h5 id="izinLabel">
                {{ $izinId ? 'Edit Pengajuan Izin' : 'Buat Pengajuan Izin' }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" 
                    aria-label="Close" wire:click="btnCloseOffcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">
               <!-- Informasi Pegawai -->
                {{-- <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div> --}}
            
                <div class="row">
                    {{-- <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="number" wire:model="telepon" class="form-control @error('telepon') is-invalid @enderror">
                        @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Jabatan dan Atasan -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select wire:model="selectJobdesk" wire:change="loadHead" 
                                class="form-select @error('selectJobdesk') is-invalid @enderror">
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->id }}">{{ $item->job }}</option>
                            @endforeach
                        </select>
                        @error('selectJobdesk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Atasan <span class="text-danger">*</span></label>
                        <select wire:model="selectHead" class="form-select @error('selectHead') is-invalid @enderror">
                            <option value="">Pilih Atasan</option>
                            @foreach ($atasan as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('selectHead') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Informasi izin -->
                <div class="mb-3">
                    <label class="form-label">Jenis Izin <span class="text-danger">*</span></label>
                    <select wire:model="id_jenis_approve" class="form-select @error('id_jenis_approve') is-invalid @enderror">
                        <option value="">Pilih Jenis Izin</option>
                        @foreach ($jenisApprove as $item)
                            <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                        @endforeach
                    </select>
                    @error('id_jenis_approve') <div class="invalid-feedback">{{ $message }}</div> @enderror
                
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Izin <span class="text-danger">*</span></label>
                    <textarea wire:model="detail_izin" rows="3" class="form-control @error('detail_izin') is-invalid @enderror"></textarea>
                    @error('detail_izin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Periode Cuti -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" wire:model="tgl_mulai" 
                               class="form-control @error('tgl_mulai') is-invalid @enderror">
                        @error('tgl_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                        <input type="date" wire:model="tgl_akhir" 
                               class="form-control @error('tgl_akhir') is-invalid @enderror">
                        @error('tgl_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Hari Cuti</label>
                    <div class="input-group">
                        <input type="number" wire:model="akumulasi" class="form-control" readonly>
                        <button type="button" wire:click="calculateIzins" class="btn btn-primary">
                            Hitung
                        </button>
                    </div>
                    <small class="text-muted">*Hari weekend tidak dihitung</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                    <input type="date" wire:model="tgl_ajuan" 
                           class="form-control @error('tgl_ajuan') is-invalid @enderror">
                    @error('tgl_ajuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Kontak Darurat -->
                <div class="mb-3">
                    <label class="form-label">Nama Kontak Darurat <span class="text-danger">*</span></label>
                    <input type="text" wire:model="nama_darurat" 
                           class="form-control @error('nama_darurat') is-invalid @enderror">
                    @error('nama_darurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. Telepon Darurat <span class="text-danger">*</span></label>
                        <input type="text" wire:model="telp_darurat" 
                               class="form-control @error('telp_darurat') is-invalid @enderror">
                        @error('telp_darurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hubungan <span class="text-danger">*</span></label>
                        <input type="text" wire:model="relasi_darurat" 
                               class="form-control @error('relasi_darurat') is-invalid @enderror">
                        @error('relasi_darurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Kontak Darurat <span class="text-danger">*</span></label>
                    <textarea wire:model="alamat" rows="2" 
                              class="form-control @error('alamat') is-invalid @enderror"></textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Delegasi Pekerjaan -->
                <div class="mb-3">
                    <label class="form-label">Nama Delegasi <span class="text-danger">*</span></label>
                    <input type="text" wire:model="nama_delegasi" 
                           class="form-control @error('nama_delegasi') is-invalid @enderror">
                    @error('nama_delegasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Delegasi <span class="text-danger">*</span></label>
                    <textarea wire:model="detail_delegasi" rows="3" 
                              class="form-control @error('detail_delegasi') is-invalid @enderror"></textarea>
                    @error('detail_delegasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Upload Dokumen -->
                <div class="mb-4">
                    <label class="form-label">Dokumen Pendukung</label>
                    @if ($file_izin)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $file_izin) }}" target="_blank" 
                               class="text-primary d-flex align-items-center">
                                <i class="fas fa-file-pdf me-2"></i>
                                {{ basename($file_izin) }}
                            </a>
                        </div>
                    @endif
                    
                    <input type="file" wire:model="newAttachment" 
                           class="form-control @error('newAttachment') is-invalid @enderror" accept=".pdf">
                    @error('newAttachment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">Format: PDF (Maks. 2MB)</small>
                    
                    @if ($newAttachment)
                        <div class="mt-2 text-sm text-success">
                            File ready: {{ $newAttachment->getClientOriginalName() }}
                        </div>
                    @endif
                    
                    <div wire:loading wire:target="newAttachment" class="mt-2 text-sm text-info">
                        <i class="fas fa-spinner fa-spin"></i> Mengunggah dokumen...
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="store">Simpan</span>
                        <span wire:loading wire:target="store">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- <div>
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="izinForm" aria-labelledby="izinFormLabel" data-bs-scroll="true" data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h5 id="izinLabel">Approval Izin Tidak Terencana</h5>
            <button wire:click="btnClose_Offcanvas" type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">

                <!--Informasi Pemohon Approval-->
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" wire:model="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror">
                        @error('no_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--Jabatan dan Atasan pemohon-->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select wire:model="selectJobdesk" wire:change="loadHead" 
                            class="form-select @error('selectJobdesk') is-invalid @enderror">
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jobdesks as $item)
                                <option value="{{ $item->id }}">{{ $item->job }}</option>
                            @endforeach
                        </select>
                        @error('selectJobdesk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Atasan <span class="text-danger">*</span></label>
                        <select wire:model="selectHead" class="form-select @error('selectHead') is-invalid @enderror">
                            <option value="">Pilih Atasan</option>
                            @foreach ($heads as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('selectHead')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!--Keperluan Approval-->
                <div class="mb-3">
                    <label class="form-label">Jenis Izin <span class="text-danger">*</span></label>
                    <input type="text" wire:model="jenis_izin" class="form-control @error('jenis_izin') is-invalid @enderror">
                    @error('jenis_izin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Izin <span class="text-danger">*</span></label>
                    <textarea wire:model="detail_izin" class="form-control @error('detail_izin') is-invalid @enderror"></textarea>
                        @error('detail_izin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                <!--Estimasi Waktu-->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" wire:model="tgl_mulai"
                            class="form-control @error('tgl_mulai') is-invalid @enderror">
                        @error('tgl_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                        <input type="date" wire:model="tgl_akhir"
                            class="form-control @error('tgl_akhir') is-invalid @enderror">
                            @error('tgl_akhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Hari Cuti</label>
                    <div class="input-group">
                        <input type="number" wire:model="akumulasi" class="form-control" readonly>
                        <button type="button" wire:click="calculateLeave" class="btn btn-sm btn-primary">
                            Hitung
                        </button>
                    </div>
                    <small class="text-muted">*Hari Weekend tidak dihitung</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                    <input type="date" wire:model="tgl_ajuan"
                        class="form-control @error('tgl_ajuan') is-invalid @enderror">
                    @error('tgl_ajuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!--Kontak Darurat-->
                <div class="mb-3">
                    <label class="form-label">Nama Kontak Darurat <span class="text-danger"></span></label>
                    <input type="text" wire:model="nama_darurat"
                        class="form-control @error('nama_darurat') is-invalid @enderror">
                </div>

                <div class="mb-3">
                    <label class="form-label">Hubungan dengan Kontak Darurat <span class="text-danger"></span></label>
                    <input type="text" wire:model="relasi_darurat"
                        class="form-control @error('relasi_darurat') is-invalid @enderror">
                </div>

                <div class="mb-3">
                    <label class="form-label">No Telepon Kontak Darurat <span class="text-danger"></span></label>
                    <input type="text" wire:model="telp_darurat"
                        class="form-control @error('telp_darurat') is-invalid @enderror">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat <span class="text-danger"></span></label>
                    <input type="text" wire:model="alamat"
                        class="form-control @error('alamat') is-invalid @enderror">
                </div>

                <!--Delegasi-->
                <div class="mb-3">
                    <label class="form-label">Nama Delegasi <span class="text-danger">*</span></label>
                    <input type="text" wire:model="nama_delegasi" class="form-control @error('nama_delegasi') is-invalid @enderror">
                    @error('nama_delegasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Delegasi <span class="text-danger">*</span></label>
                    <textarea wire:model="detail_delegasi" class="form-control @error('detail_delegasi') is-invalid @enderror"></textarea>
                        @error('detail_delegasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                <!--Dokumen Pendukung-->
                @if ($file_izin)
                    <img src="{{ asset('storage/' . $file_izin) }}" class="mb-3 w-10 h-15">
                @endif
                <div class="mb-4">
                    <label class="form-label">Dokumen Pendukung</label>
                    <input wire:model.defer="newAttachment" type="file" accept="image/png, image/jpeg" class="form-control" name="" id="newAttachment" aria-describedby="helpId" placeholder="">
                    <span wire:loading wire:target='newAttachment'>Uploading...</span>
                </div>

                @error('newAttachment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror --}}


                {{-- <div class="mb-4">
                    <label class="form-label">Dokumen Pendukung</label>
                    @if ($file_izin)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $file_izin) }}" target="_blank" class="text-success d-flex align-items-center">
                                <i class="fas fa-file-pdf me-2"></i>
                            {{ basename($file_izin) }}
                            </a>
                        </div>
                    @endif

                    <input type="file" wire:model="newAttachment"
                        class="form-control @error('newAttachment') is-invalid @enderror" accept=".pdf">
                        @error('newAttachment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">Format:PDF (maks. 10MB)</small>

                        @if ($newAttachment)
                            <div class="mt-2 text-sm text-success">
                                File Tersedia: {{ $newAttachment->getClientOriginalName() }}
                            </div>
                        @endif

                        <div wire:loading wire:target="newAttachment" class="mt-2 text-sm text-info">
                            <i class="fas fa-spinner fa-spin"></i> Mengunggah dokumen...
                        </div>
                </div> --}}

                {{-- <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="storeIzin">Simpan</span>
                        <span wire:loading wire:target="storeIzin">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                    </button>
                </div> --}}
                    {{-- <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
            </form>
        </div>
    </div>
</div> --}}
