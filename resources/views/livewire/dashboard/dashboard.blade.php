<div class="row">
    <div class="col-md-3">
        {{-- include sidebar component --}}
        @livewire('common.sidebar')
    </div>
    <div class="col-md-9">
        @can('view users')
            @livewire('user-management.userslist')
        @endcan
    </div>
</div>
