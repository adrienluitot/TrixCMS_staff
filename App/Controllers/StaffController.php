<?php

namespace Extensions\Plugins\Staff_alfiory__899612438\App\Controllers;

use Illuminate\Http\Request;
use App\System\Extensions\Plugin\Core\PluginController as Controller;
use Extensions\Plugins\Staff_alfiory__899612438\App\Models\StaffAlfioryStaffMember as StaffMember;
use Extensions\Plugins\Staff_alfiory__899612438\App\Models\StaffAlfioryRank as StaffRank;

class StaffController extends Controller
{

    public function index() {
        $staffMembers = StaffMember::get();
        $getRanks = StaffRank::get();
        $ranks = [];
        foreach ($getRanks as $rank) {
            $ranks[$rank->id] = ['name' => $rank->name, 'color' => $rank->color];
        }

        return $this->view(
            'home',
            trans('staff_alfiory::user.staff'),
            compact('staffMembers', 'ranks')
        );
    }
}
