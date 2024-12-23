<div>
    @section('title')
        Budget
    @endsection
    <div class="card p-1 table-responsive">
        <table id="budget-table" class="table table-striped table-hover table-sm" style="width:100%">
            <thead class="text-success fw-medium">
                <tr>
                    <th class="fw-medium text-center" rowspan="2">ID Project</th>
                    <th class="fw-medium text-center" rowspan="2">Project</th>
                    <th class="fw-medium text-center" rowspan="2">Project Estimation</th>
                    <th class="fw-medium text-center" rowspan="2">Budget Estimate</th>
                    {{-- <th class="fw-medium text-center" rowspan="2">Budget Plan</th>
                    <th class="fw-medium text-center" rowspan="2">Track Expense</th>
                    <th class="fw-medium text-center" colspan="2">Ratio Cost Project</th> --}}
                    <th class="fw-medium text-center" rowspan="2">Action</th>
                </tr>
                {{-- <tr>
                    <th class="fw-medium text-center">Planed Cost</th>
                    <th class="fw-medium text-center">Actual Cost</th>
                </tr> --}}
            </thead>

            <tbody>
                    @foreach ($projectData as $item)
                        <tr>
                            <td class="text-center">{{ $item->id }}</td>
                            <td class="text-center">{{ $item->title }}</td>
                            <td class="text-center">{{ $item->due_date_estimation }}</td>
                            <td class="text-center">Rp.{{ number_format($item->budget, 0, ',', '.') }}</td>
                            {{-- <td class="text-center">{{ number_format($totalPlan) }}</td>
                            <td class="text-center">{{ number_format($expense) }}</td>
                            <td class="text-center">{{ number_format($percentInitial, 2) }}%</td>
                            <td class="text-center">{{ number_format($percentFixed, 2) }}%</td> --}}
                            {{-- <td class="text-center">forget ma bad day</td> --}}
                            <td class="d-flex justify-content-center">
                                {{-- <button wire:click="dispatch->('getProjectId', {id: {{ $item->id }} })"  class="btn btn-sm btn-outline-success m-2" type="button">Budget Plan</button> --}}
                                <button wire:click='plan({{ $item->id }})'  class="btn btn-sm btn-outline-success m-2" type="button">Perencanaan</button>
                                <button wire:click='track({{ $item->id }})' class="btn btn-sm btn-outline-success m-2" type="button">Pengeluaran</button>
                            </td>
                        </tr>
                    @endforeach
                    {{-- <td class="text-center">{{ $project->title }}</td> --}}
                    {{-- <td class="text-center">{{ $project->due_date_estimation }}</td> --}}
                    {{-- <td class="text-center">{{ number_format($project->budget) }}</td> --}}
                 
            </tbody>
        </table>
    </div>

    {{-- CHART --}}
    {{-- <div class="col-md-12 col-xl-12 col-sm-12">
        <div class="card carc-switch p-3">
            <canvas id="costChart" height="250px"></canvas>
        </div>
    </div> --}}


</div>

{{-- @push('scripts')
    <script>
        const ctx = document.getElementById('costChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Project', 'Planed', 'Actual'],
                datasets: [{
                    label: 'Ratio Cost',
                    data: [{{ $percentBudget }}, {{ $percentInitial }}, {{ $percentFixed }}],
                    borderWidth: 1,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(55, 255, 31, 0.5)',
                        'rgba(255, 129, 31, 0.5)',
                    ],
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush --}}
