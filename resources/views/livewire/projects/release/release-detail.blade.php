<div>
    <div class="card card-switch">
        <div class="row">
            {{-- <h5 class="col-md-12">
                Detail
            </h5> --}}
        </div>

        <h5>{{ $result[0]->title }}</h5>
        <span>Release version {{ $result[0]->tag }} | {{ $result[0]->pj_title }}</span>
        <div class="content mt-3">
            {!! $result[0]->content !!}
        </div>
        <img src="{{ asset('storage/' . $result[0]->attachments) }}" style="width: 100%" class="mb-3"
            alt="{{ $result[0]->attachments }}">
    </div>
</div>
