@section('title', 'All Informed Approvals')

<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">List of All Informed Approvals</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover">
                <thead>
                    <tr>
                        <th>Approval Type</th> {{-- New column for type --}}
                        <th>Responsible Name</th>
                        <th>Subject</th>
                        <th>Submission Date</th>
                        <th>Status</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approvals as $item)
                        <tr>
                            <td>
                                {{ $item->approval_name ?? 'N/A' }} {{-- Display the type --}}
                            </td>
                            <td>{{ $item->user_name ?? 'N/A' }}</td>
                            <td>{{ $item->subject_name ?? $item->subject ?? $item->project_name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->submission_date)->format('d M Y H:i') ?? 'N/A' }}</td>
                            <td>
                                <span
                                    class="badge
                                    @switch($item->status_id)
                                        @case(1) {{-- Assuming 1 is Submitted --}}
                                            text-bg-primary
                                            @break
                                        @case(2) {{-- Assuming 2 is On Review --}}
                                            text-bg-info
                                            @break
                                        @case(3) {{-- Assuming 3 is Need Revision --}}
                                            text-bg-warning
                                            @break
                                        @case(4) {{-- Assuming 4 is Approved --}}
                                            text-bg-success
                                            @break
                                        @case(5) {{-- Assuming 5 is Rejected/Cancelled --}}
                                            text-bg-danger
                                            @break
                                        @default
                                            text-bg-secondary
                                    @endswitch ">{{ $item->status_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->last_updated)->format('d M Y H:i') ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center align-items-center">
                                    {{-- Dynamically generate link based on approval_name --}}
                                    @php
                                        $detailRoute = '#'; // Default if no specific route
                                        if (isset($item->approval_name)) {
                                            switch (strtolower(str_replace(' ', '', $item->approval_name))) { // Normalize name
                                                case 'permission':
                                                    $detailRoute = '/consult/permission-consult/' . $item->id;
                                                    break;
                                                case 'leaveofabsence': // Corrected from your dump for Absence
                                                    $detailRoute = '/consult/absence-consult/' . $item->id;
                                                    break;
                                                case 'rab':
                                                    // Note: You have user_id_rab for RAB, but you're getting id for the route.
                                                    // Make sure $item->id is consistent across all models for detail view.
                                                    $detailRoute = '/consult/rab-consult/' . $item->id;
                                                    break;
                                                case 'reimburse':
                                                    $detailRoute = '/consult/reimburse-consult/' . $item->id;
                                                    break;
                                                case 'projectprocurement': // Assuming this is the full name for projects
                                                    $detailRoute = '/consult/project-consult/' . $item->id;
                                                    break;
                                                // Add more cases for other approval types if needed
                                            }
                                        }
                                    @endphp
                                    <p role="button" wire:navigate href="{{ $detailRoute }}"
                                        class="text-primary m-0 p-0" style="cursor: pointer;">
                                        <i class="fa-solid fa-eye"></i> View
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No approvals found for the specified roles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
