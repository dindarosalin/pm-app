<div>
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="cutiForm" 
         aria-labelledby="cutiFormLabel" data-bs-scroll="true" data-bs-backdrop="static">
         
        <div class="offcanvas-header bg-success text-white">
            <h5 id="cutiLabel">
                {{ $cutiId ? 'Edit Pengajuan Cuti' : 'Buat Pengajuan Cuti' }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" 
                    aria-label="Close" wire:click="btnCloseOffcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store">
                <!-- Informasi Pegawai -->
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="number" wire:model="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror">
                        @error('no_telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Jabatan dan Atasan -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select wire:model="jobdesk_id" wire:change="loadHead" 
                                class="form-select @error('jobdesk_id') is-invalid @enderror">
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->id }}">{{ $item->job }}</option>
                            @endforeach
                        </select>
                        @error('jobdesk_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Atasan <span class="text-danger">*</span></label>
                        <select wire:model="head_id" class="form-select @error('head_id') is-invalid @enderror">
                            <option value="">Pilih Atasan</option>
                            @foreach ($atasan as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('head_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Informasi Cuti -->
                <div class="mb-3">
                    <label class="form-label">Jenis Cuti <span class="text-danger">*</span></label>
                    <input type="text" wire:model="jenis_cuti" class="form-control @error('jenis_cuti') is-invalid @enderror">
                    @error('jenis_cuti') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Cuti <span class="text-danger">*</span></label>
                    <textarea wire:model="detail" rows="3" class="form-control @error('detail') is-invalid @enderror"></textarea>
                    @error('detail') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Periode Cuti -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" wire:model="tanggal_mulai" 
                               class="form-control @error('tanggal_mulai') is-invalid @enderror">
                        @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Akhir <span class="text-danger">*</span></label>
                        <input type="date" wire:model="tanggal_akhir" 
                               class="form-control @error('tanggal_akhir') is-invalid @enderror">
                        @error('tanggal_akhir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Hari Cuti</label>
                    <div class="input-group">
                        <input type="number" wire:model="akumulasi" class="form-control" readonly>
                        <button type="button" wire:click="calculateDays" class="btn btn-primary">
                            Hitung
                        </button>
                    </div>
                    <small class="text-muted">*Hari weekend tidak dihitung</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pengajuan <span class="text-danger">*</span></label>
                    <input type="date" wire:model="tanggal_pengajuan" 
                           class="form-control @error('tanggal_pengajuan') is-invalid @enderror">
                    @error('tanggal_pengajuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Kontak Darurat -->
                <div class="mb-3">
                    <label class="form-label">Nama Kontak Darurat <span class="text-danger">*</span></label>
                    <input type="text" wire:model="nama_kontak_darurat" 
                           class="form-control @error('nama_kontak_darurat') is-invalid @enderror">
                    @error('nama_kontak_darurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                        <input type="text" wire:model="hubungan_darurat" 
                               class="form-control @error('hubungan_darurat') is-invalid @enderror">
                        @error('hubungan_darurat') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                    @if ($file_up)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $file_up) }}" target="_blank" 
                               class="text-primary d-flex align-items-center">
                                <i class="fas fa-file-pdf me-2"></i>
                                {{ basename($file_up) }}
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













{{--------------------------------------------------------------------------------------------------------------------- --}}
{{-- <div>
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="cutiForm" aria-labelledby="cutiFormLabel" data-bs-scroll="true" data-bs-bacdrop="false">

        <div class="offcanvas-header">
            <h5 id="cutiLabel">Pengajuan Cuti</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form wire:submit.prevent="store"> --}}

                <!--Email-->
                {{-- <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" wire:model="email" class="form-control form-control-sm">
                </div> --}}

                <!--Nama Lengkap-->
                {{-- <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="form-control form-control-sm">
                </div> --}}

                <!--Jabatan dan Atasan-->
                {{-- <div class="input-group mb-3"> --}}
                {{-- <div class="mb-3">     --}}
                    {{-- <select jobdesk_id" class="form-select form-select-sm" name="jobdesk" id="jobdesk"> --}}
                    {{-- <select wire:model="selectJobdesk" wire:change="loadHead" class="form-select form-select-sm">
                        <option value="">Pilih Jabatan</option>
                        @foreach ($this->jabatan ?? [] as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->job }}
                            </option>
                        @endforeach
                    </select> --}}
                    {{-- <button class="btn btn-outline-secondary btn-sm" wire:click="loadHead" type="button" id="button-addon2">Pilih</button> --}}
                {{-- </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">Atasan</label> --}}
                    {{-- <select wire:model="selectHead" class="form-select form-select-sm  mb-2" name="head" id="head"> --}}
                    {{-- <select wire:model="selectHead" class="form-select form-select-sm">
                        <option value="">Pilih Atasan</option>
                        @foreach ($atasan as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select> --}}
                {{-- </div> --}}
                
                <!--Informasi Cuti-->
                {{-- <div class="mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" wire:model="no_telepon" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Cuti</label>
                    <input type="text" wire:model="jenis_cuti" class="form-control form-conntrol-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Cuti</label>
                    <input type="text" wire:model="detail" class="form-control form-control-sm">
                </div> --}}

                <!--Tanggal Cuti-->
                {{-- <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" wire:model="tanggal_mulai" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" wire:model="tanggal_akhir" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Hari Cuti</label>
                    <input type="number" wire:model="akumulasi" class="form-control form-control-sm" readonly>
                    <button type="button" wire:click="calculateDays"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                        Hitung
                    </button>
                </div> --}}

                <!--Informasi Tambahan-->
                {{-- <div class="mb-3">
                    <label class="form-label">Nama Kontak Darurat</label>
                    <input type="text" wire:model="nama_kontak_darurat" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">No Telepon Kontak Darurat</label>
                    <input type="text" wire:model="telp_darurat" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Hubungan Kontak Darurat</label>
                    <input type="text" wire:model="hubungan_darurat" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" wire:model="alamat" class="form-control form-control-sm"> --}}
                {{-- </div> --}}

                <!--Delegasi Pekerjaan-->
                {{-- <div class="mb-3">
                    <label class="form-label">Nama Delegasi</label>
                    <input type="text" wire:model="nama_delegasi" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail</label>
                    <input type="text" wire:model="detail_delegasi" class="form-control form-control-sm">
                </div> --}}

                <!--File Upload-->
                {{-- @if ($file_up)
                    <a href="{{ asset('storage/' . $file_up) }}" target="_blank" class="text-blue-500 hover:underline">
                        {{ basename($file_up) }} (Klik untuk melihat)
                    </a>
                @endif

                <div class="mb-3">
                    <label class="form-label">Unggah Dokumen</label>
                    <input wire:model.defer='newAttachment' type="file" accept="file/pdf" class="form-control form-control-sm" id="newAttachment" aria-describedby="helpId" placeholder="">
                    <span wire:loading wire:target='newAttachment'>Uploading</span>
                </div> --}}
                {{-- <div class="mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" wire:model="tanggal_mulai" class="form-control form-control-sm">
                </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" wire:model="tanggal_akhir" class="form-control form-control-sm">
                </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">Akumulasi Cuti</label>
                    <input type="text" wire:model="akumulasi" class="form-control form-control-sm" value="{{ $akumulasi }}" readonly>
                </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">Tanggal Pengajuan Approval</label>
                    <input type="date" wire:model="tanggal_pengajuan" class="form-control form-control-sm">
                </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">Nama Kontak Darurat</label>
                    <input type="text" wire:model="nama_kontak_darurat" class="form-control form-conntrol-sm">
                </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">No. Telepon Kontak Darurat</label>
                    <input type="text" wire:model="telp_darurat" id="telp" class="form-control form-conntrol-sm">
                </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">Alamat Kontak Darurat</label>
                    <input type="text" wire:model="alamat" class="form-control form-conntrol-sm">
                </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">Hubungan dengan Kontak Darurat</label>
                    <input type="text" wire:click="hubungan_darurat" class="form-control form-conntrol-sm">
                </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">Detail Delegasi Pekerjaan yang Ditinggal</label>
                    <input type="text" wire:model="detail_delegasi" class="form-control form-conntrol-sm">
                </div> --}}

                {{-- <div class="mb-3">
                    <label class="form-label">Nama Delegasi Kerja</label>
                    <input type="text" wire:model="nama_delegasi" class="form-control form-conntrol-sm">
                </div> --}}

                {{-- @if ($file_up)
                    <a href="{{ asset('storage/' . $file_up) }}" target="_blank" class="text-blue-500 hover:underline">
                        {{ basename($file_up) }} (Klik untuk melihat
                    )</a>
                @endif --}}

                {{-- <div class="mb-3">
                    <label for="" class="form-label">Unggah File</label>
                    <input type="file" wire:model.defer='newAttachment' accept="file:pdf/image" class="form-control" name="" id="newAttachment" aria-describedby="helpId" placeholder="" multiple>
                    <span wire:loading wire:target='newAttachment'>Uploading</span>
                </div>

                @error('newAttachment')
                    <span class="text-danger">{{ $message }}</span>
                @enderror --}}


                {{-- <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div> --}}
