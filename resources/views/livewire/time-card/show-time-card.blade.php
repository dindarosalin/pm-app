<div>
    @section('title')
        Time Card
    @endsection
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button wire:click="$refresh" class="nav-link active" id="nav-table-time-card-tab" data-bs-toggle="tab"
                data-bs-target="#nav-table-time-card" type="button" role="tab"
                aria-controls="nav-table-time-card" aria-selected="true">Time Card</button>
            <button class="nav-link" id="nav-table-task-list-tab" data-bs-toggle="tab"
                data-bs-target="#nav-table-task-list" type="button" role="tab" aria-controls="nav-table-task-list"
                aria-selected="false">Tasks List</button>
            {{-- <button class="nav-link" id="nav-calendar-time-card-tab" data-bs-toggle="tab"
                data-bs-target="#nav-calendar-time-card" type="button" role="tab" aria-controls="nav-calendar-time-card"
                aria-selected="false">Calendar</button> --}}
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-table-time-card" role="tabpanel"
            aria-labelledby="nav-table-time-card-tab" tabindex="0">
            <livewire:time-card.table-time-card :$auth />
        </div>
        <div class="tab-pane fade" id="nav-table-task-list" role="tabpanel" aria-labelledby="nav-table-task-list-tab"
            tabindex="0">
            <livewire:time-card.table-task-list :$auth />
        </div>
        {{-- <div class="tab-pane fade" id="nav-calendar-time-card" role="tabpanel" aria-labelledby="nav-calendar-time-card-tab"
            tabindex="0">
            kalender
        </div> --}}
    </div>
</div>
