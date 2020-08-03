<link rel="stylesheet" href="@PluginAssets('css/admin/style.css')">

<div class="row">
    <div class="col-12" id="staff-main">
        <div id="alert-container">
            @if(session('staff_flash'))
                <div class="alert alert-{{session('staff_flash')['state']}}">
                    {{session('staff_flash')['message']}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>

        @yield('content')
    </div>
</div>