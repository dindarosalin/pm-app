<div>
    <div class="card">
        <div>
            <div class="d-flex gap-2 overflow-auto" style="scroll-snap-type: x mandatory;">
                @foreach ($taskScored as $s)
                    <div class="card flex-shrink-0 shadow-sm rounded p-0
                    @switch($s->task->status_name)
                                    @case('New') bg-opacity-10 bg-primary @break
                                    @case('Assign') bg-opacity-10 bg-info @break
                                    @case('On Progress') bg-opacity-10 bg-warning @break
                                    @case('Testing') bg-opacity-10 bg-warning @break
                                    @case('Done') bg-opacity-10 bg-success @break
                                    @case('Production') bg-opacity-10 bg-success @break
                                    @case('Hold') bg-opacity-10 bg-danger @break
                                    @case('Cancel') bg-opacity-10 bg-danger @break
                                @endswitch"
                        style="max-height: 120px; max-width: 250px; scroll-snap-align: start;">
                        <div class="card-body">
                            <h6 class="card-title text-center">{{ $s->task->title }}</h6>
                            <div class="d-flex justify-content-between gap-3">
                                <p class="card-text text-start">
                                    <span
                                        class="badge
                                    @switch($s->task->status_name)
                                        @case('New') bg-primary text-bg-primary @break
                                        @case('Assign') text-bg-info bg-info @break
                                        @case('On Progress') text-bg-warning bg-warning @break
                                        @case('Testing') text-bg-warning bg-warning @break
                                        @case('Done') text-bg-success bg-success @break
                                        @case('Production') text-bg-success bg-success @break
                                        @case('Hold') text-bg-danger bg-danger @break
                                        @case('Cancel') text-bg-danger bg-danger @break
                                    @endswitch">
                                        {{ $s->task->status_name }}
                                    </span>
                                </p>
                                <p class="card-text text-end">{{ $s->task->assign_to_name }}</p>
                            </div>
                            
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
