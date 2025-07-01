@section('title', 'Tasks')

<div>
    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="taskForm" aria-labelledby="taskFormLabel"
        data-bs-scroll="true">
        <div class="offcanvas-header">
            <h5 id="taskFormLabel">Form Task</h5>
            <button type="button" class="btn-close text-reset" wire:click='btnClose_Offcanvas' data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label class="form-label">Title<span class="text-sm text-danger">*</span></label>
                    <input type="text" wire:model="title" class="form-control form-control-sm" required>
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Flag<span class="text-sm text-danger">*</span></label>
                    <select wire:model='selectedFlags' id="selectedFlags" class="form-select form-select-sm" multiple>
                        @foreach ($flags as $flag)
                            <option wire:key='{{ $flag->id }}' value="{{ $flag->id }}">
                                {{ $flag->flag_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Label<span class="text-sm text-danger">*</span></label>
                    <select wire:model='selectedLabels' id="selectedLabels" class="form-select form-select-sm" multiple>
                        @foreach ($labels as $label)
                            <option wire:key='{{ $label->id }}' value="{{ $label->id }}">
                                {{ $label->label_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category<span class="text-sm text-danger">*</span></label>
                    <select wire:model='category' id="category" class="form-select form-select-sm">
                        <option value="" selected>Select Category</option>
                        @foreach ($categories as $category)
                            <option wire:key='{{ $category->id }}' value="{{ $category->id }}">
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3" wire:ignore>
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
                        <div id="editor" wire:model.defer='summary'>{{ $summary }}</div>
                        {{-- <input type="hidden" id="quill-summary"></input> --}}
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Start Date Estimation<span class="text-sm text-danger">*</span></label>
                    <input name="startDate" id="from" type="text" wire:model="start_date_estimation"
                        class="form-control form-control-sm" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">End Date Estimation<span class="text-sm text-danger">*</span></label>
                    <input name="endDate" id="to" type="text" wire:model="end_date_estimation"
                        class="form-control form-control-sm" required>
                </div>
                <div class="form-check form-switch mb-3">
                    <input wire:model='use_holiday' class="form-check-input" type="checkbox" role="switch"
                        id="flexSwitchHoliday">
                    <label class="form-check-label" for="flexSwitchHoliday">Use Holiday</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input wire:model='use_weekend' class="form-check-input" type="checkbox" role="switch"
                        id="flexSwitchWeekend">
                    <label class="form-check-label" for="flexSwitchWeekend">Use Weekend</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Assign To</label>
                    <select wire:model='assign_to' id="assign_to" class="form-select form-select-sm">
                        @if ($employees->count() >= 1)
                            <option value="" selected>Lihat Nanti</option>
                            <option value="{{ $auth }}" selected>{{ Auth::user()->user_name }}</option>
                            @foreach ($employees as $employee)
                                <option wire:key='{{ $employee['id'] }}' value="{{ $employee['id'] }}">
                                    {{ $employee['name'] }}
                                </option>
                            @endforeach
                        @else
                            <option value="{{ $auth }}" selected>{{ $auth }}</option>
                        @endif
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select wire:model='status' id="assign_to" class="form-select form-select-sm">
                        @foreach ($statuses as $status)
                            <option wire:key='{{ $status->id }}' value="{{ $status->id }}">
                                {{ $status->task_status }}</option>
                        @endforeach
                    </select>
                </div>
                <button id="submit-summary" type="submit" class="btn btn-success btn-sm">Save</button>
                <div wire:loading>
                    Saving post...
                </div>
            </form>
        </div>
    </div>

    <div wire:ignore.self class="offcanvas offcanvas-end w-50" tabindex="-1" id="viewOffCanvas"
        aria-labelledby="viewOffCanvasLabel">
        <div class="offcanvas-header">
            <h5 id="viewOffCanvasLabel">View Task</h5>
            <button type="button" class="btn-close text-reset" wire:click='btnClose_Offcanvas'
                data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if ($taskShow)
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tbody>
                            <tr>
                                <th>Project Name</th>
                                <td>{{ $taskShow->project_title }}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{ $taskShow->title }}</td>
                            </tr>
                            <tr>
                                <th>Summary</th>
                                <td>{!! $taskShow->summary !!}</td>
                            </tr>
                            <tr>
                                <th>Start</th>
                                <td>{{ $taskShow->start_date_estimation }}</td>
                            </tr>
                            <tr>
                                <th>End</th>
                                <td>{{ $taskShow->end_date_estimation }}</td>
                            </tr>
                            <tr>
                                <th>Use Holiday</th>
                                <td>
                                    @if ($taskShow->use_holiday == 0)
                                        <span class="badge text-bg-secondary">False</span>
                                    @else
                                        <span class="badge text-bg-success">True</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Use Weekend</th>
                                <td>
                                    @if ($taskShow->use_weekend == 0)
                                        <span class="badge text-bg-secondary">False</span>
                                    @else
                                        <span class="badge text-bg-success">True</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{ $taskShow->created_by_name }}</td>
                            </tr>
                            <tr>
                                <th>Assign To</th>
                                <td>{{ $taskShow->assign_to_name }}</td>
                            </tr>
                            <tr>
                                <th>Flags</th>
                                <td>{{ $taskShow->flag }}</td>
                            </tr>
                            <tr>
                                <th>Labels</th>
                                <td>{{ $taskShow->label }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{ $taskShow->category_name }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span
                                        class="badge
                                @switch($taskShow->status_name)
                                    @case('New')
                                        text-bg-primary
                                        @break
                                    @case('Assign')
                                        text-bg-info
                                        @break
                                    @case('On Progress')
                                        text-bg-warning
                                        @break
                                    @case('Testing')
                                        text-bg-warning
                                        @break
                                    @case('Done')
                                        text-bg-success
                                        @break
                                    @case('Production')
                                        text-bg-success
                                        @break
                                    @case('Hold')
                                        text-bg-danger
                                        @break
                                    @case('Cancel')
                                        text-bg-danger
                                        @break
                                @endswitch ">{{ $taskShow->status_name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- <div class="p-3">
                <form>
                    @csrf
                    <p class="fw-bold">Comments ({{ $countComment > 0 ? $countComment : 0 }})</p>
                    <div>
                        <div wire:ignore>
                            <div id="live_comment"></div>
                        </div>
                    </div>
                </form>
                <button class="btn btn-success btn-sm mt-2" id='submit_comment' type="button"
                    wire:click='sendComment'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                        <path
                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
                    </svg> send</button>
                <div wire:loading wire:target="sendComment">
                    Saving post...
                </div>
            </div> --}}
            @endif
            @livewire('projects.tasks.comments')
        </div>
    </div>

    <div class="row mb-2">
        <div class="col col-md-8">
            <p>Nama Project: {{ $projectDetail->title }}, Jumlah Task: {{ $totalTask }}, Completion:
                {{ $projectDetail->completion }}%, Status Project: {{ $projectDetail->status }}</p>
        </div>
        <div class="col text-end">
            <button wire:click="$dispatch('show-create-offcanvas')" class="btn btn-success btn-sm col"><i
                    class="fa-solid fa-plus"></i></button>
            {{-- @dd($projectId); --}}
            <a href="{{ route('projects.tasks.archived', $projectId) }}" role="button"
                class="btn btn-danger btn-sm col text-white" wire:navigate>
                <i class="fa-solid fa-box-archive"></i></a>
        </div>
    </div>

    <div class="card">
        @include('livewire.projects.tasks.filter')

        <div class="card-body table-responsive px-0">
            <livewire:projects.tasks.priorities :projectId="$projectId" :auth="$auth" :tasks="$tasks" />
            <table class="table table-sm table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th role="button" wire:click="sortBy('score')">Priority
                            <i class="fa-solid fa-arrows-up-down"></i>
                        </th>
                        <th role="button" wire:click="sortBy('title')">Title
                            <i class="fa-solid fa-arrows-up-down"></i>
                        </th>
                        <th role="button" wire:click="sortBy('start_date_estimation')">Start
                            <i class="fa-solid fa-arrows-up-down"></i>
                        </th>
                        <th role="button" wire:click="sortBy('end_date_estimation')">End
                            <i class="fa-solid fa-arrows-up-down"></i>
                        </th>
                        {{-- <th>Created By</th> --}}
                        <th role="button" wire:click="sortBy('assign_to')">Assign To
                            <i class="fa-solid fa-arrows-up-down"></i>
                        </th>
                        <th>Category</th>
                        <th role="button" wire:click="sortBy('status_id')">Status
                            <i class="fa-solid fa-arrows-up-down"></i>
                        </th>
                        <th>Flags</th>
                        <th>Holiday</th>
                        <th>Weekend</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr wire:key='{{ $task->id }}'>
                            <td>{{ $task->score }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ date('d F Y', strtotime($task->start_date_estimation)) }}</td>
                            <td>{{ date('d F Y', strtotime($task->end_date_estimation)) }}</td>
                            {{-- <td>{{ $task->created_by_name }}</td> --}}
                            <td>{{ $task->assign_to_name }}</td>
                            <td>{{ $task->category_name }}</td>
                            <td>
                                <span
                                    class="badge
                                    @switch($task->status_name)
                                        @case('New')
                                            text-bg-primary
                                            @break
                                        @case('Assign')
                                            text-bg-info
                                            @break
                                        @case('On Progress')
                                            text-bg-warning
                                            @break
                                        @case('Testing')
                                            text-bg-warning
                                            @break
                                        @case('Done')
                                            text-bg-success
                                            @break
                                        @case('Production')
                                            text-bg-success
                                            @break
                                        @case('Hold')
                                            text-bg-danger
                                            @break
                                        @case('Cancel')
                                            text-bg-danger
                                            @break
                                    @endswitch ">{{ $task->status_name }}
                                </span>
                            </td>
                            <td>
                                {{ $task->flag }}
                            </td>
                            <td>
                                @if ($task->use_holiday == 1)
                                    <i class="fa-solid fa-square-check text-success"></i>
                                @else
                                    <i class="fa-solid fa-square-xmark text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @if ($task->use_weekend == 1)
                                    <i class="fa-solid fa-square-check text-success"></i>
                                @else
                                    <i class="fa-solid fa-square-xmark text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center align-items-center">
                                    <!-- View icon -->
                                    <btn wire:click="$dispatch('showById', {id: {{ $task->id }}})"
                                        class="text-primary m-0">
                                        <i class="fa-regular fa-eye"></i>
                                    </btn>

                                    <!-- Edit icon -->
                                    <btn role="button" wire:click="$dispatch('edit', {id: {{ $task->id }} })"
                                        class="text-warning m-0">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </btn>

                                    <!-- Delete icon -->
                                    <btn role="button" wire:click="alertConfirm({{ $task->id }})"
                                        {{-- <p role="button" wire:click="$dispatch('alertConfirm', {id: {{ $task->id }}})"  --}} class="text-danger m-0">
                                        <i class="fa-solid fa-box-archive"></i>
                                    </btn>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- <div class="accordion accordion-flush">
        @foreach ($statuses as $status)
            <div class="accordion-item" style="background: transparent;">
                <button style="width: 100%; text-align: left; background: transparent; padding-left: 12px"
                    class="accordion-button border rounded shadow-none fw-sm border-success text-success btn-sm mb-2 d-flex gap-2 align-items-center"
                    type="button" data-bs-toggle="collapse" data-bs-target="#status{{ $status->id }}"
                    aria-expanded="false" aria-controls="collapseExample">
                    <span class="badge text-bg-success">{{ $taskCounts[$status->id] }}</span>
                    {{ $status->task_status }}

                </button>
                <div class="collapse" id="status{{ $status->id }}" wire:ignore>
                    <div class="card">
                        <livewire:projects.tasks.table-status :$projectId :$auth :status="$status->id" :key="$status->id" />
                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}
    {{-- @dd($projectDetail->start_date) --}}
</div>

@push('scripts')
    // DATE VALIDATE
    <script>
        let projectDate = new Date("{{ \Carbon\Carbon::parse($projectDetail->start_date)->format('Y-m-d') }}")
        $(function() {
            var dateFormat = "yy/mm/dd",
                from = $("#from")
                .datepicker({
                    defaultDate: "",
                    changeMonth: true,
                    numberOfMonths: 2,
                    minDate: projectDate,
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                    // $wire.start_date_estimation = $(this).val();
                }),
                to = $("#to").datepicker({
                    defaultDate: "",
                    changeMonth: true,
                    numberOfMonths: 2
                })
                .on("change", function() {
                    from.datepicker("option", "maxDate", getDate(this));
                    // $wire.end_date_estimation = $(this).val();
                });

            $('form').on('submit', function(e) {
                let fromVal = $('#from').val();
                let toVal = $('#to').val();

                // Ubah format mm/dd/yyyy ke yyyy/mm/dd
                function toYMD(dateStr) {
                    if (!dateStr) return '';
                    let parts = dateStr.split('/');
                    if (parts.length !== 3) return dateStr;
                    return `${parts[2]}-${parts[0].padStart(2, '0')}-${parts[1].padStart(2, '0')}`;
                }

                @this.set('start_date_estimation', toYMD(fromVal));
                @this.set('end_date_estimation', toYMD(toVal));
            });


            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.2/quill.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('post-created', (event) => {
                //
            });
        });
        window.addEventListener('show-create-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#taskForm');
            offcanvas.show();
        });
        window.addEventListener('show-edit-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#taskForm');
            offcanvas.show();
        });
        window.addEventListener('close-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#taskForm');
            offcanvas.hide();
        });
        window.addEventListener('show-view-offcanvas', event => {
            const offcanvas = new bootstrap.Offcanvas('#viewOffCanvas');
            offcanvas.show();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Quill editor

            const quill = new Quill('#editor', {
                modules: {
                    syntax: true,
                    toolbar: '#toolbar-container',
                },
                placeholder: 'Summary task',
                theme: 'snow',
            });

            // Handle manual submission
            $('#submit-summary').on('click', function() {
                var summary = quill.root.innerHTML;
                @this.set('summary', summary); // Set the summary manually when submitting
            });

            $(document).on('load-summary', function() {
                var summary = event.detail.summary;
                // console.log(summary);

                quill.root.innerHTML = summary;
            });

            window.addEventListener('clear-summary', event => {
                quill.root.innerHTML = ''; // Clear the Quill editor's summary
            });
        });
    </script>
    <script>
        //Comment

        document.addEventListener('DOMContentLoaded', function() {
            var form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                // Lakukan apa yang perlu dilakukan setelah form dikirim
                // contoh: submit form menggunakan AJAX atau fetch
            });
        });



        // $(document).ready(function() {
        //     const comments = new Quill('#live_comment', {
        //         placeholder: 'Type comment...',
        //         theme: 'snow' // or 'bubble'
        //     });


        //     // Handle manual submission
        //     $('#submit_comment').on('click', function() {
        //         var comment = comments.root.innerHTML;
        //         @this.set('comment',
        //             comment); // Set the summary manually when submitting
        //     });

        //     window.addEventListener('clear-comment', event => {
        //         comments.root.innerHTML = ''; // Clear the Quill editor's summary
        //     });
        // });
    </script>
@endpush
