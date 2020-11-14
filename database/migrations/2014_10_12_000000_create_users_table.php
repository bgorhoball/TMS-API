<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User as Model;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Model::TABLE_NAME, function (Blueprint $table) {
            $table->bigIncrements(Model::FIELD_ID);
            $table->string(Model::FIELD_NAME);
            $table->string(Model::FIELD_EMAIL)->unique();
            $table->timestamp(Model::FIELD_EMAIL_VERIFIED_AT)->nullable();
            $table->string(Model::FIELD_PASSWORD);
            $table->rememberToken();
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
        Schema::dropIfExists(Model::TABLE_NAME);
    }
}
