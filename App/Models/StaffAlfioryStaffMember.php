<?php

namespace Extensions\Plugins\Staff_alfiory__899612438\App\Models;

use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Model;

class StaffAlfioryStaffMember extends Model
{
    use CacheQueryBuilder;

    protected $table = 'staff_alfiory__staff_members';
    protected $fillable = ['name', 'image_url', 'ranks_id', 'description', 'links'];

    public function create(array $attributes = [])
    {
        return parent::create($attributes); // TODO: Change the autogenerated stub
    }
}
