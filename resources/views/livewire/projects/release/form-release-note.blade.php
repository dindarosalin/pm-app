<div>
    <div>
        <!-- Modal -->
        <div wire:ignore.self class="modal modal-xl fade" id="newReleaseNote" data-bs-backdrop="false"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="createReleaseNote" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdrop">New Release Note</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form>
                            {{-- =========================== TITLE =========================== --}}
                            <div class="col-md-12 mb-2">
                                <label for="title">Title<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Title" wire:model.defer='title'>
                            </div>
                            <div class="col-md-12">
                                <div class="row g-3 align-items-end">
                                    {{-- =========================== TAG VERSION =========================== --}}
                                    <div class="col-sm-2">
                                        <label for="tag" class="form-label">Version</label>
                                        <input type="text" class="form-control" id="tag" name="tag"
                                            placeholder="v 1.1.0" wire:model.defer='tag'>
                                    </div>

                                    {{-- =========================== PROJECT ===========================--}}
                                    <div class="col-md-10 col-sm-12">
                                        {{-- {{ dd($projects) }} --}}
                                        <label for="project" class="form-label">Project<span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="Project" name="Project"
                                            aria-label="Default select example" wire:model.defer='projectId' disabled>
                                            <option selected>Open this select menu</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>

                            {{-- =========================== RICH TEXT QUILL JS =========================== --}}
                            <div class="col-md-12 mt-4" wire:ignore>
                                <div id="toolbar-container">
                                    <span class="ql-formats">
                                        <select class="ql-header"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <select class="ql-align"></select>
                                        <button class="ql-list" value="ordered"></button>
                                        <button class="ql-list" value="bullet"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-link"></button>
                                    </span>
                                </div>
                                <div>
                                    <div id="editor" wire:model.defer='content'>{{ $content }}</div>
                                    {{-- <input type="hidden" id="quill-content"></input> --}}
                                </div>
                            </div>
                            <hr>

                            {{-- =========================== PREVIEW IMAGE SAAT UPDATE ===========================--}}
                            @if ($attachments)
                                <img src="{{ asset('storage/' . $attachments) }}" class="mb-3  w-25 h-auto">
                            @endif

                            {{-- =========================== ATTACHMENT IMAGE =========================== --}}
                            <div class="mb-3">
                                <label for="" class="form-label">Attachment File</label>
                                <input wire:model.defer='newattachments' type="file" accept="image/png, image/jpeg"
                                    class="form-control" name="" id="newattachments" aria-describedby="helpId"
                                    placeholder="" />
                                <span wire:loading wire:target='newattachments'>Uploading...</span>
                            </div>

                            @error('newattachments')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </form>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='cancel'>Batal</button>
                        <button wire:click='save' wire:loading.attr="disabled" type="button" id="submit-content"
                            class="btn btn-primary">Simpan</button>
                        <div class="" wire:loading wire:target='save'>Saving...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Quill editor

            const quill = new Quill('#editor', {
                modules: {
                    syntax: true,
                    toolbar: '#toolbar-container',
                },
                placeholder: 'Pesan release...',
                theme: 'snow',
            });

            // Handle manual submission
            $('#submit-content').on('click', function() {
                var content = quill.root.innerHTML;
                @this.set('content', content); // Set the content manually when submitting
            });

            $(document).on('load-content', function() {
                var content = event.detail.content;
                // console.log('ini content');

                quill.root.innerHTML = content;
            });

            window.addEventListener('clear-content', event => {
                quill.root.innerHTML = ''; // Clear the Quill editor's content

                // Close Bootstrap modal
                const modalElement = document.getElementById(
                    'newReleaseNote'); // Ganti dengan ID modal kamu
                const modalInstance = bootstrap.Modal.getInstance(modalElement); // Ambil instance modal
                modalInstance.hide(); // Tutup modal
            });

            // GENERATE DATA
            $(document).on('populateQuill', function() {
                var tasks = event.detail.tasks;
                let quillContent = '';
                // let content += '<h3>List</h3></br><ol>' + quillContent + '</ol>';
                // console.log(tasks);


                if (Array.isArray(tasks)) {
                    tasks.forEach(task => {
                        quillContent +=
                            `<p><strong>${task.title}:</strong> ${task.summary}</p>`;
                        // console.log(quillContent);
                        quill.root.innerHTML = quillContent;
                    });
                } else {
                    quill.root.innerHTML = '';
                    // console.error("Tasks is not an array:", tasks);
                }

                // console.log(quillContent);
                // quill.root.innerHTML = '';
            });

            // window.addEventListener('populateQuill', event => {
            //     let quillContent = '';
            //     // console.log(tasks);
            //     // Build the content string from tasks
            //     event.detail.tasks.forEach(tasks => {
            //         quillContent += `<p><strong>${task.title}:</strong> ${task.summary}</p>`;
            //         console.log(quillContent);
            //     });

            //     // Insert the content into the Quill editor
            //     quill.root.innerHTML = quillContent;

            // });
        });

        // document.addEventListener('livewire:load', function() {
        //     window.addEventListener('populateQuill', event => {
        //         let quillContent = '';

        //         // Build the content string from tasks
        //         event.detail.tasks.forEach(task => {
        //             quillContent += `<p><strong>${task.title}:</strong> ${task.summary}</p>`;
        //         });

        //         // Insert the content into the Quill editor
        //         quill.root.innerHTML = quillContent;

        //     });
        // });
    </script>
@endpush
