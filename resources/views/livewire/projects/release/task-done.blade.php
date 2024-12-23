<div>
    {{-- <div class="row"> --}}
    <h5 class="col-md-9 col-xl-9 col-sm-12">Release Note</h5>

    <button 
    wire:click="generateReleaseNote" 
    class="btn btn-success col-md-3 col-xl-3 col-sm-12 btn-sm" 
    type="button" 
    data-bs-toggle="modal" 
    data-bs-target="#newReleaseNote" 
    wire:loading.attr="disabled" 
    {{ !$selectedTasks ? 'disabled' : '' }}>
    Generate Release Notes 
    <span wire:loading wire:target="generateReleaseNote">....</span>
</button>

    {{-- <div wire:loading='generateReleaseNote'>Loading</div> --}}
    {{-- Table --}}
    <table id="project-table" class="table table-striped table-hover table-sm" style="width:100%">
        <thead>
            <th>
                <input class="form-check-input" type="checkbox" value="" id="checkAll">
            </th>
            {{-- <th>project title</th> --}}
            <th wire:click="sortBy('title')">
                <button class="btn btn-sm fw-medium text-success d-flex gap-1 align-items-center">Title
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                    </svg>
                </button>
            </th>
            <th>Summary</th>
            <th>Label</th>
            <th wire:click="sortBy('start_date_estimation')">
                <button class="btn btn-sm fw-medium text-success d-flex gap-1 align-items-center">Start
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                    </svg>
                </button>
            </th>
            <th wire:click="sortBy('end_date_estimation')">
                <button class="btn btn-sm fw-medium text-success d-flex gap-1 align-items-center">End
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                    </svg>
                </button>
            </th>
            <th>Created By</th>
            <th>Assign To</th>
            <th>Status</th>
            </tr>
        </thead>
        <tbody>
            {{-- @dd($tasks); --}}
            @foreach ($tasks as $task)
                <tr wire:key='{{ $task->id }}'>
                    <td>
                        <input class="form-check-input task-checkbox" type="checkbox" value="{{ $task->id }}"
                            id="flexCheck">
                    </td>
                    {{-- <td>{{ $task->project_title }}</td> --}}
                    <td>{{ $task->title }}</td>
                    <td>{!! \Illuminate\Support\Str::limit($task->summary, 25) !!}</td>
                    <td>Label</td>
                    <td>{{ $task->start_date_estimation }}</td>
                    <td>{{ $task->end_date_estimation }}</td>
                    <td>{{ $task->created_by_name }}</td>
                    <td>{{ $task->assign_to_name }}</td>
                    <td>
                        <span class="badge text-bg-success">{{ $task->status_name }}</span>
                    </td>
            @endforeach
        </tbody>

    </table>
</div>

@push('scripts')
    {{-- <script>
        // Handle "check all" functionality
        const checkAllBox = document.getElementById('checkAll');
        const checkboxes = Array.from(document.querySelectorAll('.task-checkbox'));

        // Function to check if all checkboxes are checked
        function checkIfAllSelected() {
            const allChecked = checkboxes.every(checkbox => checkbox.checked);
            checkAllBox.checked = allChecked; // Update the state of the "check all" checkbox

        }

        // Event listener for "check all" checkbox
        checkAllBox.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked; // Check/uncheck all based on "check all" state
            });
        });

        // Event listener for individual checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', function() {
                checkIfAllSelected(); // Correctly call the function to update "check all" checkbox state
            });
        });

        // Call the function once when the page is loaded to set the initial state
        checkIfAllSelected();
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkAllBox = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.task-checkbox');

            // Event listener untuk checkbox "Check All"
            checkAllBox.addEventListener('change', function() {
                const isChecked = this.checked;

                // Check/uncheck semua checkbox individual
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });

                // Kirim data ID semua task ke Livewire
                const selectedIds = isChecked ?
                    Array.from(checkboxes).map(checkbox => checkbox.value) :
                    [];
                    @this.set('selectedTasks', selectedIds);
                // Livewire.dispatch('updateSelectedTasks', selectedIds); // Emit event ke Livewire
            });

            // Event listener untuk checkbox individual
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    checkAllBox.checked = allChecked; // Update status checkbox "Check All"

                    // Ambil semua ID yang dicheck
                    const selectedIds = Array.from(checkboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);
                    @this.set('selectedTasks', selectedIds);
                });
            });
        });
    </script>
@endpush
