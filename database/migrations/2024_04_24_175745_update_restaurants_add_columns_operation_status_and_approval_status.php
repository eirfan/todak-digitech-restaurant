<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants',function(Blueprint $table) {
            $table->enum('operation_status',['active','inactive'])->default('inactive');
            $table->enum('approval_status',['pending','approve','rejected'])->default('pending');
            $table->bigInteger('manager_id')->unsigned()->nullable();
            $table->foreign('manager_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants',function(Blueprint $table) {
            $table->dropForeign('restaurants_manager_id_foreign');
            $table->dropColumn(['operation_status','approval_status','manager_id']);
        });
    }
};
