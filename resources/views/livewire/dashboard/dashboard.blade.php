<div class="row">
    <div class="col-md-3">
        {{-- include sidebar component --}}
        @livewire('common.sidebar')
    </div>
    <div class="col-md-9">
        @role('admin')
            @livewire('user-management.userslist')
        @endrole
    </div>
</div>
