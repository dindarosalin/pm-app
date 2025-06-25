@section('title', 'Dashboard Consulted')

<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    Approval Total {{ $approvalTotal }}
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Approval Types</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($approvals as $item)
                            <tr>
                                <td>{{ $item->user_name }}</td>
                                <td>{{ $item->subject_name }}</td>
                                <td>{{ $item->approval_name }}</td>
                                <td>{{ $item->submission_date }}</td>
                                <td>
                                    <span
                                        class="badge
                                        @switch($item->status_id)
                                            @case('1') text-bg-primary @break
                                            @case('2') text-bg-info @break
                                            @case('3') text-bg-warning @break
                                            @case('4') text-bg-success @break
                                            @case('5') text-bg-danger @break
                                        @endswitch">
                                        {{ $item->status_name }}
                                    </span>
                                </td>
                                <td>{{ $item->last_updated }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

