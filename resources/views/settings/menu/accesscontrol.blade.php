<x-layouts.app>
@section('title')
    Menu
@endsection
<div>
    @livewire('settings.menu.access-control',['menu_id'=>$menu_id])
</div>
</x-layouts.app>
