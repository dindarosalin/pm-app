
<div>
    <div class="row mb-2 card-header">
        <input type="text" wire:model.live.debounce="search" class="form-control form-control-sm col"
            placeholder="Search Task Title..." />
    </div>
    <div class="table-responsive card-body p-0">
        <table class="table table-sm table-bordered table-hover text-center" >
            <thead>
                <tr>
                    <th role="button" wire:click="sortBy('title')">Title
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                    </th>
                    <th role="button" wire:click="sortBy('start_date_estimation')">Start
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                    </th>
                    <th role="button" wire:click="sortBy('end_date_estimation')">End
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                    </th>
                    {{-- <th>Created By</th> --}}
                    <th>Assign To</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Flags</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr wire:key='{{ $task->id }}'>
                        <td>{{ $task->title }}</td>
                        <td>{{ date('d F Y', strtotime($task->start_date_estimation)) }}</td>
                        <td>{{ date('d F Y', strtotime($task->end_date_estimation)) }}</td>
                        {{-- <td>{{ $task->created_by_name }}</td> --}}
                        <td>{{ $task->assign_to_name }}</td>
                        <td>{{ $task->category_name }}</td>
                        <td>
                            <span class="badge
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
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <!-- View icon -->
                                <btn wire:click="$dispatch('showById', {id: {{ $task->id }}})" class="btn btn-outline-primary btn-sm m-0">
                                    <i class="fa-regular fa-eye"></i>
                                </btn>

                                <!-- Edit icon -->
                                <btn role="button" wire:click="$dispatch('edit', {id: {{ $task->id }} })" class="btn btn-outline-warning btn-sm m-0">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </btn>

                                <!-- Delete icon -->
                                <btn role="button" wire:click="alertConfirm({{ $task->id }})"

                                {{-- <p role="button" wire:click="$dispatch('alertConfirm', {id: {{ $task->id }}})"  --}}
                                    class="btn btn-outline-danger btn-sm m-0">
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
