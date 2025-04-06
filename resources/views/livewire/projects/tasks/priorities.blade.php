<div>
    <div class="card">
    <table class="table table-sm table-bordered table-hover text-center" >
                <thead>
                    <tr>
                        <th>Task Id</th>
                        <th>Name</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taskScored as $r)
                        <tr>
                            <td>{{$r->task_id}}</td>
                            <td>{{$r->task_name}}</td>
                            <td>{{$r->score}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
