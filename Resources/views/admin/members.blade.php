@extends('Plugins.Staff_alfiory__899612438.Resources.views.layouts.admin')


@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-th-list"></i> {{trans('staff_alfiory::admin.members_list')}}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="staff-members-list">
                    <thead>
                    <tr>
                        <th>{{trans('staff_alfiory::admin.name')}}</th>
                        <th>{{trans('staff_alfiory::admin.image')}}</th>
                        <th>{{trans('staff_alfiory::admin.ranks')}}</th>
                        <th>{{trans('staff_alfiory::admin.description')}}</th>
                        <th>{{trans('staff_alfiory::admin.links')}}</th>
                        <th>{{trans('staff_alfiory::admin.manage')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $deletedRanks = [];
                        @endphp
                        @foreach($members as $member)
                            <tr data-member-id="{{$member->id}}">
                                <td class="member-name">{{$member->name}}</td>
                                <td class="member-image">{{$member->image_url}}</td>
                                <td class="member-ranks">
                                    @if(!empty($member->ranks_id))
                                        @foreach(json_decode($member->ranks_id) as $rankId)
                                            @if(isset($ranks[$rankId]))
                                                <span class="rank" style="background: #{{$ranks[$rankId]['color']}};">{{$ranks[$rankId]['name']}}</span>
                                            @else
                                                @php $deletedRanks[] = $rankId; @endphp
                                                <span class="rank" style="background: #555;font-style:italic;font-weight: bold;">Undefined</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="member-desc">@if(!empty($member->ranks_id)) {{Str::limit($member->description, 50, '...')}} @endif</td>
                                <td class="member-links">
                                    @if(!empty($member->links))
                                        @foreach(json_decode($member->links, true) as $link)
                                            <span class="member-link" style="color: #{{$link[2]}};">
                                                <i class="{{$link[1]}}"></i> [{{Str::limit($link[0], 50, '...')}}]
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_MEMBER|DASHBOARD_STAFF_DELETE_MEMBER|admin'))
                                    <td>
                                        @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_MEMBER|admin'))
                                            <a class="edit-member" data-toggle="modal" data-target="#edit-member-modal" data-id="{{$member->id}}" data-ranks="{{$member->ranks_id}}" data-links="{{$member->links}}" data-image="{{$member->image_url}}" data-name="{{$member->name}}" data-description="{{$member->description}}"><i class="fas fa-cog"></i></a>
                                        @endif

                                        @if(user()->hasPermission('DASHBOARD_STAFF_DELETE_MEMBER|admin')) <a class="delete-member"><i class="fas fa-trash"></i></a> @endif
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
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus"></i> {{trans('staff_alfiory::admin.add_member')}}</h6>
        </div>
        <div class="card-body">
            <div id="add-member-form">
                <div id="add-member-alert"></div>

                <div class="form-group col-md-6">
                    <label>{{trans('staff_alfiory::admin.name')}}</label>
                    <input class="form-control" id="name" placeholder="{{trans('staff_alfiory::admin.name')}}">
                </div>

                <div class="form-group col-md-8 col-lg-6">
                    <label>{{trans('staff_alfiory::admin.image')}}</label>
                    <input class="form-control" id="image" placeholder="{{trans('staff_alfiory::admin.image_ph')}}">
                    {!! (egame()->if("tx_minecraft")->isEnable())? "<small>".trans('staff_alfiory::admin.image_info_minecraft')."</small>" : "" !!}
                </div>

                <div class="form-group col-12">
                    <label>{{trans('staff_alfiory::admin.links')}}</label>
                    <div class="links">
                        <div class="link row">
                            <div class="col-1 orderer">
                                <a class="order-up"><i class="fas fa-angle-up"></i></a>
                                <a class="order-down"><i class="fas fa-angle-down"></i></a>
                            </div>
                            <div class="col-4">
                                <input type="text" class="link-url form-control" placeholder="{{trans('staff_alfiory::admin.link_ph')}}">
                            </div>
                            <div class="col-3">
                                <input type="text" class="link-icon form-control" placeholder="{{trans('staff_alfiory::admin.icon_ph')}}">
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">#</span>
                                    </div>
                                    <input type="text" class="form-control link-color" placeholder="{{trans('staff_alfiory::admin.color')}}">
                                </div>
                            </div>
                            <div class="col-1">
                                <button class="remove-link btn btn-danger"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-sm btn-primary add-link"><i class="fas fa-plus"></i></button>
                </div>

                <div class="form-group col-md-12">
                    <label>{{trans('staff_alfiory::admin.ranks')}}</label>
                    <div class="ranks">
                        @foreach($ranks as $rankId => $rank)
                            <div class="rank" data-rank-id="{{$rankId}}" style="background: #{{$rank['color']}};">
                                <span class="rank-name">{{$rank['name']}}</span>
                                <span class="rank-checked"></span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group col-md-10 col-lg-8">
                    <label>{{trans('staff_alfiory::admin.description')}}</label>
                    <textarea class="form-control" id="description" rows="4" placeholder="{{trans('staff_alfiory::admin.description')}}"></textarea>
                </div>

                <div class="form-group col-12">
                    <button type="button" class="btn btn-success" id="add-staff-member">{{trans('staff_alfiory::admin.add')}}</button>
                </div>
            </div>
        </div>
    </div>

    @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_MEMBER|admin'))
        <div class="modal fade" id="edit-member-modal" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{trans("staff_alfiory::admin.edit")}} <em id="edit-member-title"></em></h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <input type="hidden" id="edit-member-id">

                    <div class="form-group col-md-6">
                        <label>{{trans('staff_alfiory::admin.name')}}</label>
                        <input class="form-control" id="edit-member-name" placeholder="{{trans('staff_alfiory::admin.name')}}">
                    </div>

                    <div class="form-group col-md-8 col-lg-6">
                        <label>{{trans('staff_alfiory::admin.image')}}</label>
                        <input class="form-control" id="edit-member-image" placeholder="{{trans('staff_alfiory::admin.image_ph')}}">
                        {!! (egame()->if("tx_minecraft")->isEnable())? "<small>".trans('staff_alfiory::admin.image_info_minecraft')."</small>" : "" !!}
                    </div>

                    <div class="form-group col-12">
                        <label>{{trans('staff_alfiory::admin.links')}}</label>
                        <div class="links"></div>

                        <button class="btn btn-sm btn-primary add-link"><i class="fas fa-plus"></i></button>
                    </div>

                    <div class="form-group col-md-12">
                        <label>{{trans('staff_alfiory::admin.ranks')}}</label>
                        <div class="ranks">
                            @foreach($ranks as $rankId => $rank)
                                <div class="rank" data-rank-id="{{$rankId}}" style="background: #{{$rank['color']}};">
                                    <span class="rank-name">{{$rank['name']}}</span>
                                    <span class="rank-checked"></span>
                                </div>
                            @endforeach
                            @foreach($deletedRanks as $rankId)
                                <div class="rank" data-rank-id="{{$rankId}}" style="background: #555;">
                                    <span class="rank-name" style="font-style: italic;font-weight: bold;">Undefined</span>
                                    <span class="rank-checked"></span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <label>{{trans('staff_alfiory::admin.description')}}</label>
                        <textarea class="form-control" id="edit-member-description" rows="4" placeholder="{{trans('staff_alfiory::admin.description')}}"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('staff_alfiory::admin.cancel')}}</button>
                        <button type="button" class="btn btn-primary" id="update-member">{{trans('staff_alfiory::admin.edit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(user()->hasPermission('DASHBOARD_STAFF_ADD_MEMBER|DASHBOARD_STAFF_EDIT_MEMBER|DASHBOARD_STAFF_DELETE_MEMBER|admin'))
        <script>
            $('.ranks').on('click', '.rank', function () {
               $(this).toggleClass("enabled");
            });

            $('.add-link').on('click', function () {
                $(this).parent().find('.links').append('<div class="link row">\n' +
                        '<div class="col-1 orderer">\n' +
                            '<a class="order-up"><i class="fas fa-angle-up"></i></a>\n' +
                            '<a class="order-down"><i class="fas fa-angle-down"></i></a>\n' +
                        '</div>\n' +
                        '<div class="col-4">\n' +
                            '<input type="text" id="link" class="link-url form-control" placeholder="{{trans('staff_alfiory::admin.link_ph')}}">\n' +
                        '</div>\n' +
                        '<div class="col-3">\n' +
                            '<input type="text" id="icon" class="link-icon form-control" placeholder="{{trans('staff_alfiory::admin.icon_ph')}}">\n' +
                        '</div>\n' +
                        '<div class="col-3">\n' +
                            '<div class="input-group">\n' +
                                '<div class="input-group-prepend">\n' +
                                    '<span class="input-group-text">#</span>\n' +
                                '</div>\n' +
                                    '<input type="text" class="link-color form-control" placeholder="{{trans('staff_alfiory::admin.color')}}">\n' +
                                '</div>\n' +
                            '</div>' +
                        '<div class="col-1">\n' +
                            '<button class="remove-link btn btn-danger"><i class="fas fa-trash"></i></button>\n' +
                        '</div>\n' +
                    '</div>');
            });

            $('.links').on('click', '.remove-link', function() {
                $(this).closest('.link').remove();
            });

            $('.links').on('click', '.remove-link', function() {
                $(this).closest('.link').remove();
            });

            $('.links').on('click', '.order-up', function () {
                let link = $(this).closest('.link');
                link.insertBefore(link.prev('.link'));
            });
            $('.links').on('click', '.order-down', function () {
                let link = $(this).closest('.link');
                link.insertAfter(link.next('.link'));
            });

            let ranksList = {
                @foreach($ranks as $rankId => $rank)
                    {{$rankId}}: ["{{$rank['name']}}","{{$rank['color']}}"],
                @endforeach
            };

            @if(user()->hasPermission('DASHBOARD_STAFF_ADD_MEMBER|admin'))
                // ADD STAFF
                $('#add-staff-member').on('click', () => {
                    $("#add-staff-member").prop('disabled', true);

                    let links = [];
                    $('#add-member-form .links').find('.link').each(function () {
                        links.push([$(this).find('.link-url').val(), $(this).find('.link-icon').val(), $(this).find('.link-color').val()])
                    });

                    let ranks = [];
                    $('#add-member-form .ranks').find('.rank.enabled').each(function () {
                        ranks.push($(this).data('rank-id'));
                    });

                    $.ajax({
                        url: '{{route('admin.staff_alfiory.add_member')}}',
                        type: "post",
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                        },
                        data: {
                            name: $('#name').val(),
                            image: $('#image').val(),
                            links: links,
                            ranks: ranks,
                            description: $('#description').val()
                        },
                        success: (data) => {
                            $('#add-member-form .invalid-feedback').remove();

                            let memberRanks = "";
                            for(let id in ranks) {
                                memberRanks += '<span class="rank" style="background: #'+ranksList[ranks[id]][1]+'">'+ranksList[ranks[id]][0]+'</span>';
                            }

                            let memberLinks = "";
                            for(let id in links) {
                                memberLinks += '<span class="member-link" style="color: #'+links[id][2].replace('#', '')+'"><i class="'+links[id][1]+'"></i> ['+links[id][0]+']</span>';
                            }

                            $("#staff-members-list tbody").append("<tr data-member-id='"+data.id+"'>" +
                                    "<td class=\"member-name\">" +  $('#name').val() + "</td>" +
                                    "<td class=\"member-image\">" +  $('#image').val() + "</td>" +
                                    "<td class=\"member-ranks\">" + memberRanks + "</td>" +
                                    "<td class=\"member-description\">" + $('#description').val().substr(0, 50) + (($('#description').val().length > 50)? '...' : '') + "</td>" +
                                    "<td class=\"member-links\">" + memberLinks + "</td>" +
                                    @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_MEMBER|DASHBOARD_STAFF_DELETE_MEMBER|admin'))
                                        "<td>" +
                                            @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_MEMBER|admin'))
                                                "<a class='edit-member' data-toggle='modal' data-target='#edit-member-modal' data-id='"+data.id+"' data-name='"+$('#name').val()+"' data-image='"+$('#image').val()+"' data-ranks='"+JSON.stringify(ranks)+"' data-description='"+$('#description').val()+"' data-links='"+JSON.stringify(links)+"'><i class='fas fa-cog'></i></a>" +
                                            @endif
                                            @if(user()->hasPermission('DASHBOARD_STAFF_DELETE_MEMBER|admin'))
                                                "<a class='delete-member'><i class='fas fa-trash'></i></a>" +
                                            @endif
                                        "</td>" +
                                    @endif
                                "</tr>");
                            $("#add-member-alert").html('<div class="alert alert-success">' +
                                    data.message +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                        '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                '</div>');

                            $('#add-member-form input, #add-member-form textarea').removeClass("is-invalid").val("");
                            $('#add-member-form .rank').removeClass("enabled");
                            $('#add-member-form .link:not(:first-child)').remove();
                            $("#add-staff-member").prop('disabled', false);
                        },
                        error: (data) => {
                            let errors = data.responseJSON.errors;

                            $('#add-member-form .invalid-feedback').remove();
                            $('#add-member-form input').removeClass("is-invalid");

                            for(let error in errors) {
                                let input;
                                if(error.indexOf("links") == -1) {
                                    input = $('#' + error);
                                } else {
                                    let link = error.split('.');
                                    input = $($($('#add-member-form .link')[link[1]]).find('input')[link[2]]);
                                }
                                input.addClass('is-invalid');
                                input.parent().append('<span class="invalid-feedback">'+errors[error]+'</span>');
                            }
                            $("#add-staff-member").prop('disabled', false);
                        }
                    });
                });
            @endif

            @if(user()->hasPermission('DASHBOARD_STAFF_DELETE_MEMBER|admin'))
                // DELETE member
                $("#staff-members-list").on('click', "tr:not(.disabled) .delete-member", function () {
                    let memberId = $(this).closest("tr").data('member-id');
                    $(this).closest('tr').addClass("disabled");

                    $.ajax({
                        url: '{{route('admin.staff_alfiory.delete_member')}}',
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                        },
                        data: 'id=' + memberId,
                        success: (data) => {
                            $("#alert-container").html('<div class="alert alert-success" id="staff-alert">' +
                                    data.message +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                        '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                '</div>');

                            $('tr[data-member-id=' + memberId+']').remove();
                        },
                        error: () => {
                            $("#alert-container").html('<div class="alert alert-danger" id="staff-alert">' +
                                    '{{trans("staff_alfiory::admin.error_deleting_member")}}' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                        '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                '</div>');
                        }
                    });
                });
            @endif

            // EDIT member
            @if(user()->hasPermission('DASHBOARD_STAFF_EDIT_MEMBER|admin'))
                $('#edit-member-modal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);

                    $('#edit-member-modal .link').remove();
                    $('#edit-member-description').val("");
                    $('#edit-member-modal .rank').removeClass("enabled");

                    $("#edit-member-title").text(button.data('name'));
                    $("#edit-member-image").val(button.data('image'));
                    $("#edit-member-name").val(button.data('name'));
                    $("#edit-member-description").val(button.data('description'));
                    $("#edit-member-id").val(button.data('id'));

                    let ranks = button.data('ranks');
                    let links = button.data('links');

                    for (let id in ranks) {
                        $('#edit-member-modal .rank[data-rank-id=' + ranks[id] + ']').addClass("enabled");
                    }

                    for (let id in links) {
                        $('#edit-member-modal .links').append('<div class="link row">\n' +
                                '<div class="col-1 orderer">\n' +
                                    '<a class="order-up"><i class="fas fa-angle-up"></i></a>\n' +
                                    '<a class="order-down"><i class="fas fa-angle-down"></i></a>\n' +
                                '</div>\n' +
                                '<div class="col-4">\n' +
                                    '<input type="text" class="link-url form-control" value="'+links[id][0]+'" placeholder="{{trans('staff_alfiory::admin.link_ph')}}">\n' +
                                '</div>\n' +
                                '<div class="col-3">\n' +
                                    '<input type="text" class="link-icon form-control" value="'+links[id][1]+'" placeholder="{{trans('staff_alfiory::admin.icon_ph')}}">\n' +
                                '</div>\n' +
                                '<div class="col-3">\n' +
                                    '<div class="input-group">\n' +
                                        '<div class="input-group-prepend">\n' +
                                            '<span class="input-group-text">#</span>\n' +
                                        '</div>\n' +
                                        '<input type="text" class="form-control link-color" value="'+links[id][2]+'" placeholder="{{trans('staff_alfiory::admin.color')}}">\n' +
                                    '</div>\n' +
                                '</div>\n' +
                                '<div class="col-1">\n' +
                                    '<button class="remove-link btn btn-danger"><i class="fas fa-trash"></i></button>\n' +
                                '</div>\n' +
                            '</div>');
                    }
                });

                $("#update-member").on('click', function () {
                    $("#update-member").prop('disabled', true);
                    let memberId = $("#edit-member-id").val();

                    let links = [];
                    $('#edit-member-modal .links').find('.link').each(function () {
                        links.push([$(this).find('.link-url').val(), $(this).find('.link-icon').val(), $(this).find('.link-color').val()])
                    });

                    let ranks = [];
                    $('#edit-member-modal .ranks').find('.rank.enabled').each(function () {
                        ranks.push($(this).data('rank-id'));
                    });

                    $.ajax({
                        url: '{{route('admin.staff_alfiory.edit_member')}}',
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                        },
                        data: {
                            id: $('#edit-member-id').val(),
                            name: $('#edit-member-name').val(),
                            image: $('#edit-member-image').val(),
                            links: links,
                            ranks: ranks,
                            description: $('#edit-member-description').val()
                        },
                        success: (data) => {
                            $('#edit-member-modal .invalid-feedback').remove();
                            $("#alert-container").html('<div class="alert alert-success" id="staff-alert">' +
                                    data.message +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                        '<span aria-hidden="true">&times;</span>' +
                                    '</button>' +
                                '</div>');

                            let memberRanks = "";
                            for(let id in ranks) {
                                memberRanks += '<span class="rank" style="background: #'+ranksList[ranks[id]][1]+'">'+ranksList[ranks[id]][0]+'</span>';
                            }

                            let memberLinks = "";
                            for(let id in links) {
                                memberLinks += '<span class="member-link" style="color: #'+links[id][2].replace('#', '')+'"><i class="'+links[id][1]+'"></i> ['+links[id][0]+']</span>';
                            }

                            $("tr[data-member-id=" + memberId + "] .member-name").text($("#edit-member-name").val());
                            $("tr[data-member-id=" + memberId + "] .member-image").text($("#edit-member-image").val());
                            $("tr[data-member-id=" + memberId + "] .member-description").text($("#edit-member-description").val());
                            $("tr[data-member-id=" + memberId + "] .member-ranks").html(memberRanks);
                            $("tr[data-member-id=" + memberId + "] .member-links").html(memberLinks);

                            $("tr[data-member-id=" + memberId + "] .edit-member")
                                .data('name', $("#edit-member-name").val())
                                .data('description', $("#edit-member-description").val())
                                .data('image', $("#edit-member-image").val())
                                .data('ranks', ranks)
                                .data('links', links);

                            $('#edit-member-modal').modal('hide');
                            $("#update-member").prop('disabled', false);
                        },
                        error: (data) => {
                            let errors = data.responseJSON.errors;
                            $('#edit-member-modal .invalid-feedback').remove();
                            $('#edit-member-modal input').removeClass("is-invalid");

                            for(let error in errors) {
                                let input;
                                if(error.indexOf("links") == -1) {
                                    input = $('#edit-member-' + error);
                                } else {
                                    let link = error.split('.');
                                    input = $($($('#edit-member-modal .link')[link[1]]).find('input')[link[2]]);
                                }
                                input.addClass('is-invalid');
                                input.parent().append('<span class="invalid-feedback">'+errors[error]+'</span>');
                            }

                            $("#update-member").prop('disabled', false);
                        }
                    });
                });
            @endif
        </script>
    @endif
@endsection