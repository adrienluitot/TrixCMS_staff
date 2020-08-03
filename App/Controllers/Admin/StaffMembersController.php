<?php

namespace Extensions\Plugins\Staff_alfiory__899612438\App\Controllers\Admin;

use Illuminate\Http\Request;
use App\System\Extensions\Plugin\Core\PluginController as AdminController;
use Extensions\Plugins\Staff_alfiory__899612438\App\Models\StaffAlfioryStaffMember as StaffMember;
use Extensions\Plugins\Staff_alfiory__899612438\App\Models\StaffAlfioryRank as StaffRank;


class StaffMembersController extends AdminController
{

    public $admin = true;

    public function index () {
        $members = StaffMember::get();
        $getRanks = StaffRank::get();
        $ranks = [];
        foreach ($getRanks as $rank) {
            $ranks[$rank->id] = ['name' => $rank->name, 'color' => $rank->color];
        }
        // $users = Get_all_users'_name

        return $this->view(
            'admin.members',
            trans('staff_alfiory::admin.staff') . ' - ' . trans('staff_alfiory::admin.members'),
            compact('members', 'ranks')
        );
    }

    public function add_member (Request $request) {
        $request->validate([
            "name" => ['required', 'string', 'max:255'],
            "image" => ['nullable', 'url'],
            "links" => ['nullable', 'array'],
            "links.*.0" => ['required', 'url'],
            "links.*.1" => ['required', 'string'],
            "links.*.2" => ['required', 'regex:/^#?([0-9a-f]{3}){1,2}$/i'],
            "ranks" => ['nullable', 'array'],
            "ranks.*" => ['required', 'integer'],
            "description" => ['nullable', 'string'],
        ],
        [
            "max" => trans('staff_alfiory::admin.field_string_too_long'),
            "required" => trans('staff_alfiory::admin.required'),
            "url" => trans('staff_alfiory::admin.url_wrong_format'),
            "links.*.2.regex" => trans('staff_alfiory::admin.color_wrong_format'),
        ]);

        $memberId = StaffMember::insertGetId([
            'name' => $request->name,
            'image_url' => $request->image,
            'ranks_id' => (!empty($request->ranks))? json_encode($request->ranks) : NULL,
            'description' => $request->description,
            'links' => (!empty($request->links))? json_encode($request->links) : NULL,
            'created_at' => now()
        ]);

        return ['message' => trans('staff_alfiory::admin.added_member'), 'id' => $memberId];
    }

    public function delete_member (Request $request) {
        $request->validate([
            "id" => ['required', 'integer'],
        ]);

        StaffMember::findOrFail($request->id)->delete();

        return ['message' => trans('staff_alfiory::admin.deleted_member')];
    }

    public function edit_member (Request $request) {
        $request->validate([
            "name" => ['required', 'string', 'max:255'],
            "image" => ['nullable', 'url'],
            "links" => ['nullable', 'array'],
            "links.*.0" => ['required', 'url'],
            "links.*.1" => ['required', 'string'],
            "links.*.2" => ['required', 'regex:/^#?([0-9a-f]{3}){1,2}$/i'],
            "ranks" => ['nullable', 'array'],
            "ranks.*" => ['required', 'integer'],
            "description" => ['nullable', 'string'],
        ],
        [
            "max" => trans('staff_alfiory::admin.field_string_too_long'),
            "required" => trans('staff_alfiory::admin.required'),
            "url" => trans('staff_alfiory::admin.url_wrong_format'),
            "links.*.2.regex" => trans('staff_alfiory::admin.color_wrong_format'),
        ]);

        StaffMember::findOrFail($request->id)->update([
            'name' => $request->name,
            'image_url' => $request->image,
            'ranks_id' => (!empty($request->ranks))? json_encode($request->ranks) : NULL,
            'description' => $request->description,
            'links' => (!empty($request->links))? json_encode($request->links) : NULL,
            'updated_at' => now()
        ]);

        return ['message' => trans('staff_alfiory::admin.edited_member')];
    }
}
