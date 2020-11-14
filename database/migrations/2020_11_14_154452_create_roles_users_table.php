<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_users', function (Blueprint $table) {
            $table->unsignedBigInteger(\App\Models\Role::FIELD_ID);
            $table->unsignedBigInteger(\App\Models\User::FIELD_ID);
            $table->foreign(\App\Models\Role::FIELD_ID)->references(\App\Models\Role::FIELD_ID)->on(\App\Models\Role::TABLE_NAME);
            $table->foreign(\App\Models\User::FIELD_ID)->references(\App\Models\User::FIELD_ID)->on(\App\Models\User::TABLE_NAME);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_users');
    }
}
