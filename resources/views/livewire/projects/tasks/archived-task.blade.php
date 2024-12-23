@section('title', 'Archived Tasks')
<div class="card">
    <div class="table-responsive">
        <table class="table table-sm table-bordered table-hover">
            <thead class="text-center">
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Deleted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($archivedTasks) --}}
                @foreach ($archivedTasks as $t)
                    <tr>
                        <td>{{ $t->title }}</td>
                        <td class="text-center">
                            <span class="badge
                                @switch($t->status_name)
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
                                @endswitch ">{{ $t->status_name }}
                            </span>
                        </td>
                        <td>{{ $t->created_at }}</td>
                        <td>{{ $t->deleted_at }}</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <!-- Restore icon -->
                                <btn role="button" wire:click="restore({{ $t->id }})" class="btn btn-outline-warning btn-sm m-0">
                                    <i class="fa-solid fa-arrow-rotate-left"></i>
                                </btn>

                                <!-- Delete icon -->
                                <btn role="button" 
                                    {{-- wire:click="alertConfirm({{ $t->id }})" --}}
                                    class="btn btn-outline-danger btn-sm m-0"
                                    wire:click="delete({{ $t->id }})"
                                    wire:confirm="Are you sure you want to delete this post?"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </btn>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
