<div>
    <div class="card card-switch">
        

        @livewire('projects.release.task-done', ['projectId' => $projectId])

    </div>

    <div class="card card-switch">

        @livewire('projects.release.form-release-note', ['projectId' => $projectId])

        <div class="p-2"></div>



        <div class="table">

            {{-- Memanggil view dan mengirimkan projectId  --}}
            @livewire('projects.release.show-release-note', ['projectId' => $projectId])
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

    {{-- <script> --}}
    const quill = new Quill('#release-note', {
    theme: 'snow'
    });
    </script>
@endpush
