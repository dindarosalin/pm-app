@section('title', 'Archived Projects')
<div class="card">
    <div class="table-responsive">
        <table class="table table-sm table-bordered table-hover">
            <thead class="text-center">
                <tr>
                    <th>Title</th>
                    <th>Created At</th>
                    <th>Deleted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archivedProjects as $p)
                    <tr>
                        <td>{{ $p->title }}</td>
                        <td>{{ $p->created_at }}</td>
                        <td>{{ $p->deleted_at }}</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center align-items-center">
                                <!-- Restore icon -->
                                <btn role="button" wire:click="restore({{ $p->id }})" class="btn btn-outline-warning btn-sm m-0">
                                    <i class="fa-solid fa-arrow-rotate-left"></i>
                                </btn>

                                <!-- Delete icon -->
                                <btn role="button" 
                                    {{-- wire:click="alertConfirm({{ $p->id }})" --}}
                                    class="btn btn-outline-danger btn-sm m-0"
                                    wire:click="delete({{ $p->id }})"
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

