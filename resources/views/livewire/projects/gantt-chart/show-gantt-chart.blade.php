<div>
    @section('title')
        Gantt Chart
    @endsection
    <div class="card p-4">
        <div class="card-header">
            <div>
                <p>Nama Project: {{ $projectDetail->title }}, Completion:
                    {{ $projectDetail->completion }}%, Status Project: {{ $projectDetail->status }}</p>
                    <span class="badge rounded-pill gantt-weekend">Weekend</span>
                    <span class="badge rounded-pill gantt-holiday">Holiday</span>
            </div>
        </div>
        <div class="card-body">
            <div id="myGantt" style="width: 100%; height: 600px;"></div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            console.log("Livewire loaded and gantt initialized");
            gantt.config.work_time = true;
            gantt.config.enable_task_creation = false;

            gantt.config.xml_date = "%Y-%m-%d %H:%i";
            gantt.config.scales = [{
                    unit: "month",
                    step: 1,
                    format: "%M"
                },
                {
                    unit: "year",
                    step: 1,
                    format: "%Y"
                },
                {
                    unit: "day",
                    format: "%D, %d"
                }
            ];
            gantt.config.scale_height = 3 * 30;
            gantt.init("myGantt");

            gantt.config.columns = [{
                name: "text",
                label: "Task name",
                width: "*",
                tree: true
            }, {
                name: "start_date",
                label: "Start time",
                align: "center"
            }, {
                name: "duration",
                label: "Duration",
                align: "center"
            }];

            const holidays = @json($holidays);

            // Check if a given date is a holiday and get its name if it is
            function getHoliday(date) {
                const formattedDate = gantt.date.date_to_str("%Y-%m-%d")(date);
                const holiday = holidays.find(h => h.date === formattedDate);
                console.log(holiday);
                return holiday ? holiday.name : null;
            }

            gantt.templates.scale_cell_class = function(date) {
                if (getHoliday(date)) {
                    return "gantt-holiday";
                }
                if (date.getDay() === 0 || date.getDay() === 6) {
                    return "gantt-weekend";
                }
            };

            gantt.templates.timeline_cell_class = function(item, date) {
                if (getHoliday(date)) {
                    return "gantt-holiday";
                }
                if (date.getDay() === 0 || date.getDay() === 6) {
                    return "gantt-weekend";
                }
            };

            // Display holiday name as a tooltip
            // gantt.templates.timeline_cell_attr = function(item, date) {
            //     const holidayName = getHoliday(date);
            //     if (holidayName) {
            //         return `title="${holidayName}"`;
            //     }
            //     return "";
            // };

            gantt.parse({
                data: @json($tasks)
            });
        });
    </script>
@endpush
