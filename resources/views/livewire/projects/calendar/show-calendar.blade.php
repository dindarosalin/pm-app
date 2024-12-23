<div>
    @section('title')
        Calendar
    @endsection
    <div class="card p-4">
        <div class="card-header">
            <div class="">
                <p>Nama Project: {{ $projectDetail->title }}, Completion:
                    {{ $projectDetail->completion }}%, Status Project: {{ $projectDetail->status }}</p>
    
            </div>
        </div>
        <div id='calendar-container'>
            <div id='calendar'></div>
        </div>
    </div>
    
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            console.log(@json($events));
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                height: 800,
                contentHeight: 780,
                aspectRatio: 1.8,
                dayMaxEvents: true,
                navLinks: true,
                nowIndicator: true,
                initialView: 'dayGridMonth',
                firstDay: 1,
                eventColor: '#CFF2DE',
                events: @json($events),
            });

            calendar.render();
        });
    </script>
@endpush
