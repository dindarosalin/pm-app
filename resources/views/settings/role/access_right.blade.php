<x-layouts.app>

@section('title')
    Role
@endsection

@livewire('settings.role.access-right-component', ['role_id'=>$role_id, "menu_id"=>$menu_id])
</x-layouts.app>
