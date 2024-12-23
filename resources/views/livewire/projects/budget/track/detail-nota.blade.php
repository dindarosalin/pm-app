<div>
    <div class="card">
        <div class="row">
                
            <h5>{{ $nota[0]->name }}</h5>
            <span>{{ $nota[0]->sub_category_name }} | {{ $nota[0]->category_name }}</span>
            <img src="{{ asset('storage/' . $nota[0]->attachment) }}" style="width: 60%" class="mb-3" alt="{{ $nota[0]->attachment }}">
        </div>
    </div>
</div>
