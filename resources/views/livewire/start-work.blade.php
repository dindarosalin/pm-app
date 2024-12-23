<div>
    @section('title', 'Start Work')

    @if(!$isButtonDisabled) <div class="alert alert-warning" role="alert">
        Please start before work!
      </div> @endif

    <div class="card">
        <div class="card-body content-center text-center">
            <img style="width:20%;" src="{{asset ('assets/img/undraw_remotely.svg') }}"></img>
            <h5 class="h-4">Start Work Now?</h5>
            <p class="card-text">Do you want start to work today?</p>
            @if(!$isButtonDisabled)<button wire:click='store'   class="btn btn-success btn-sm">Yes, Start Now</button>@endif
            @if($isButtonDisabled) <p class="fw-semibold">You are started today, start again tomorrow.</p> @endif
        </div>
    </div>
</div>
