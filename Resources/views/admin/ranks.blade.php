@extends('Plugins.Staff_alfiory__899612438.Resources.views.layouts.admin')


@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-th-list"></i> {{trans('staff_alfiory::admin.ranks_list')}}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="staff-ranks-list">
                    <thead>
                        <tr>
                            <th>{{trans('staff_alfiory::admin.id')}}</th>
                            <th>{{trans('staff_alfiory::admin.name')}}</th>
                            <th>{{trans('staff_alfiory::admin.color')}}</th>
                            <th>{{trans('staff_alfiory::admin.manage')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ranks as $rank)
                            <tr data-rank-id="{{$rank->id}}">
                                <td># {{$rank->id}}</td>
                                <td class="rank-name"><span class="rank" style="background: #{{$rank->color}};">{{$rank->name}}</span></td>
                                <td class="rank-color">#{{$rank->color}}</td>
                                @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_RANK|DASHBOARD_STAFF_DELETE_RANK|admin'))
                                    <td>
                                        @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_RANK|admin'))
                                            <a class="edit-rank" data-toggle="modal" data-target="#edit-rank-modal" data-id="{{$rank->id}}" data-name="{{$rank->name}}" data-color="{{$rank->color}}"><i class="fas fa-cog"></i></a>
                                        @endif

                                        @if(user()->hasPermission('DASHBOARD_STAFF_DELETE_RANK|admin')) <a class="delete-rank"><i class="fas fa-trash"></i></a> @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus"></i> {{trans('staff_alfiory::admin.add_rank')}}</h6>
        </div>
        <div class="card-body">
            <form method="post" class="row" id="add-rank-form">
                <div class="form-group col-md-6">
                    <label>{{trans('staff_alfiory::admin.name')}}</label>
                    <input class="form-control" id="name" placeholder="{{trans('staff_alfiory::admin.name')}}">
                </div>

                <div class="form-group col-md-6">
                    <label>{{trans('staff_alfiory::admin.color')}}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">#</span>
                        </div>
                        <input type="text" id="color" class="form-control" placeholder="{{trans('staff_alfiory::admin.color')}}">
                    </div>
                    <small>{{trans("staff_alfiory::admin.hex_color_explanation")}}</small>
                </div>

                <div class="form-group col-12">
                    <button type="button" class="btn btn-success" id="add-staff-rank">{{trans('staff_alfiory::admin.add')}}</button>
                </div>
            </form>
        </div>
    </div>

    @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_RANK|admin'))
        <div class="modal fade" id="edit-rank-modal" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{trans("staff_alfiory::admin.edit")}} <span id="edit-rank-title"></span></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" id="edit-rank-id">

                    <div class="modal-body">
                        <div class="form-group col-12">
                            <label>{{trans('staff_alfiory::admin.name')}}</label>
                            <input type="text" id="edit-rank-name" class="form-control" placeholder="{{trans('staff_alfiory::admin.name')}}">
                        </div>

                        <div class="form-group col-12">
                            <label>{{trans('staff_alfiory::admin.color')}}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">#</span>
                                </div>
                                <input type="text" id="edit-rank-color" class="form-control" placeholder="{{trans('staff_alfiory::admin.color')}}">
                            </div>
                            <small>{{trans("staff_alfiory::admin.hex_color_explanation")}}</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('staff_alfiory::admin.cancel')}}</button>
                        <button type="button" class="btn btn-primary" id="update-rank">{{trans('staff_alfiory::admin.edit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(user()->hasPermission('DASHBOARD_STAFF_ADD_RANK|DASHBOARD_STAFF_EDIT_RANK|DASHBOARD_STAFF_DELETE_RANK|admin'))
        <script>
            @if(user()->hasPermission('DASHBOARD_STAFF_ADD_RANK|admin'))
                // ADD STAFF
                $('#add-staff-rank').on('click', () => {
                    $("#add-staff-rank").prop('disabled', true);

                    $.ajax({
                        url: '{{route('admin.staff_alfiory.add_rank')}}',
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                        },
                        data: 'name=' + $('#name').val() + '&color=' + $('#color').val(),
                        success: (data) => {
                            $('#add-rank-form .invalid-feedback').remove();
                            $("#staff-ranks-list tbody").append("<tr data-rank-id='"+data.id+"'>" +
                                    "<td># " + data.id  + "</td>" +
                                    "<td class=\"rank-name\"><span class='rank' style='background: #" + $('#color').val().replace("#", "") + ";'>" +  $('#name').val() + "</span></td>" +
                                    "<td class=\"rank-color\">#" + $('#color').val().replace("#", "") + "</td>" +
                                    @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_RANK|DASHBOARD_STAFF_DELETE_RANK|admin'))
                                        "<td>" +
                                            @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_RANK|admin'))
                                                "<a class='edit-rank' data-toggle='modal' data-target='#edit-rank-modal' data-id='"+data.id+"' data-name='"+$('#name').val()+"' data-color='"+$('#color').val().replace('#', '')+"'><i class='fas fa-cog'></i></a>" +
                                            @endif
                                            @if(user()->hasPermission('DASHBOARD_STAFF_DELETE_RANK|admin'))
                                                "<a class='delete-rank'><i class='fas fa-trash'></i></a>" +
                                            @endif
                                        "</td>" +
                                    @endif
                                "</tr>");
                            $("#alert-container").html('<div class="alert alert-success" id="staff-alert">' +
                                    data.message +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                        '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                '</div>');

                            $('#add-rank-form input').removeClass("is-invalid").val("");
                            $("#add-staff-rank").prop('disabled', false);
                        },
                        error: (data) => {
                            let errors = data.responseJSON.errors;
                            $('#add-rank-form .invalid-feedback').remove();
                            $('#add-rank-form input').removeClass("is-invalid");

                            for(let error in errors) {
                                let input = $('#' + error);
                                input.addClass('is-invalid');
                                input.parent().append('<span class="invalid-feedback">'+errors[error]+'</span>');
                            }
                            $("#add-staff-rank").prop('disabled', false);
                        }
                    });
                });
            @endif

            @if(user()->hasPermission('DASHBOARD_STAFF_DELETE_RANK|admin'))
                // DELETE RANK
                $("#staff-ranks-list").on('click', "tr:not(.disabled) .delete-rank", function () {
                    let catId = $(this).closest("tr").data('rank-id');
                    $(this).closest('tr').addClass("disabled");

                    $.ajax({
                        url: '{{route('admin.staff_alfiory.delete_rank')}}',
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                        },
                        data: 'id=' + catId,
                        success: (data) => {
                            $("#alert-container").html('<div class="alert alert-success" id="staff-alert">' +
                                    data.message +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                        '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                '</div>');

                            $('tr[data-rank-id=' + catId+']').remove();
                        },
                        error: () => {
                            $("#alert-container").html('<div class="alert alert-danger" id="staff-alert">' +
                                    '{{trans("staff_alfiory::admin.error_deleting_rank")}}' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                        '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                '</div>');
                        }
                    });
                });
            @endif

            // EDIT RANK
            @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_RANK|admin'))
                $('#edit-rank-modal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);

                    $("#edit-rank-title").text(button.data('name'));
                    $("#edit-rank-name").val(button.data('name'));
                    $("#edit-rank-color").val(button.data('color'));
                    $("#edit-rank-id").val(button.data('id'));
                });

                $("#update-rank").on('click', function () {
                    let catId = $("#edit-rank-id").val();

                    $.ajax({
                        url: '{{route('admin.staff_alfiory.edit_rank')}}',
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                        },
                        data: 'id=' + catId + "&name=" + $("#edit-rank-name").val() + "&color=" + $("#edit-rank-color").val(),
                        success: (data) => {
                            $('#edit-rank-modal .invalid-feedback').remove();
                            $("#alert-container").html('<div class="alert alert-success" id="staff-alert">' +
                                    data.message +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                        '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                '</div>');

                            $("tr[data-rank-id=" + catId + "] .rank-name span").text($("#edit-rank-name").val()).css('background', "#" + $("#edit-rank-color").val().replace("#", ""));
                            $("tr[data-rank-id=" + catId + "] .rank-color").text("#"+$("#edit-rank-color").val().replace("#", ""));
                            $("tr[data-rank-id=" + catId + "] .edit-rank").data('name', $("#edit-rank-name").val()).data('color', $("#edit-rank-color").val().replace("#", ""));

                            $('#edit-rank-modal').modal('hide');
                        },
                        error: (data) => {
                            let errors = data.responseJSON.errors;
                            $('#edit-rank-modal .invalid-feedback').remove();
                            $('#edit-rank-modal input').removeClass("is-invalid");

                            for(let error in errors) {
                                let input = $('#edit-rank-' + error);
                                input.addClass('is-invalid');
                                input.parent().append('<span class="invalid-feedback">'+errors[error]+'</span>');
                            }
                        }
                    });
                });
            @endif
        </script>
    @endif
@endsection