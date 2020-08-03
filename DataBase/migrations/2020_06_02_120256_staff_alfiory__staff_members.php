<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StaffAlfioryStaffMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_alfiory__staff_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->text('ranks_id')->nullable();
            $table->text('description')->nullable();
            $table->text('image_url')->nullable();
            $table->text('links')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_alfiory__staff_members');
    }
}
