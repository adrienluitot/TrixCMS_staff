<?php

namespace Extensions\Plugins\Staff_alfiory__899612438\App\Controllers\Admin;

use Illuminate\Http\Request;
use App\System\Extensions\Plugin\Core\PluginController as AdminController;
use Extensions\Plugins\Staff_alfiory__899612438\App\Models\StaffAlfioryRank as StaffRank;


class RanksController extends AdminController
{

    public $admin = true;

    public function index () {
        $ranks = StaffRank::get();

        return $this->view(
            'admin.ranks',
            trans('staff_alfiory::admin.staff') . ' - ' . trans('staff_alfiory::admin.ranks'),
            compact('ranks')
        );
    }

    public function add_rank (Request $request) {
        $request->validate([
            "name" => ['required', 'string', 'max:255'],
            "color" => ['required', 'string', 'regex:/^#?([0-9a-f]{3}){1,2}$/i']
        ],
        [
            "name.required" => trans('staff_alfiory::admin.required'),
            "name.max" => trans('staff_alfiory::admin.field_string_too_long'),
            "color.required" => trans('staff_alfiory::admin.required'),
            "color.regex" => trans('staff_alfiory::admin.color_wrong_format')
        ]);

        $categoryId = StaffRank::insertGetId([
            'name' => $request->name,
            'color' => str_replace("#", "", $request->color),
            'created_at' => now()
        ]);

        return ['message' => trans('staff_alfiory::admin.added_rank'), 'id' => $categoryId];
    }

    public function delete_rank (Request $request) {
        $request->validate([
            "id" => ['required', 'integer'],
        ]);

        StaffRank::findOrFail($request->id)->delete();

        return ['message' => trans('staff_alfiory::admin.deleted_rank')];
    }

    public function edit_rank (Request $request) {
        $request->validate([
            "id" => ['required', 'integer'],
            "name" => ['required', 'string', 'max:255'],
            "color" => ['required', 'string', 'regex:/^#?([0-9a-f]{3}){1,2}$/i']
        ],
        [
            "name.required" => trans('staff_alfiory::admin.required'),
            "name.max" => trans('staff_alfiory::admin.field_string_too_long'),
            "color.required" => trans('staff_alfiory::admin.required'),
            "color.regex" => trans('staff_alfiory::admin.color_wrong_format')
        ]);

        StaffRank::findOrFail($request->id)->update([
            'name' => $request->name,
            'color' => str_replace("#", "", $request->color),
            'updated_at' => now()
        ]);

        return ['message' => trans('staff_alfiory::admin.edited_rank')];
    }
}
