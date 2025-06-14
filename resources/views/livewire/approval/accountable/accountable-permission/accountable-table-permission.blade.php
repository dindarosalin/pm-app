@section('title', 'Permission List')

<div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>Responsible Name</th>
                        <th>Subject</th>
                        <th>Submission Date</th>
                        <th>Status</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $item)
                        <tr>
                            <td>{{ $item->user_name }}</td>
                            <td>{{ $item->subject_name }}</td>
                            <td>{{ $item->submission_date }}</td>
                            <td>
                                <span
                                        class="badge
                                @switch($item->status_id)
                                    @case('1')
                                        text-bg-primary
                                        @break
                                    @case('2')
                                        text-bg-info
                                        @break
                                    @case('3')
                                        text-bg-warning
                                        @break
                                    @case('4')
                                        text-bg-success
                                        @break
                                    @case('5')
                                        text-bg-danger
                                        @break
                                @endswitch ">{{ $item->status_name }}
                            </td>
                            <td>{{ $item->last_updated }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center align-items-center">
                                    <p role="button" wire:navigate href="/accountable/permission-table-accountable/{{ $item->id }}"
                                        class="text-primary m-0 p-0" style="cursor: pointer;">
                                        <i class="fa-solid fa-eye"></i>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

