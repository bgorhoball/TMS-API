<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Work as Model;

class CreateWorksTable extends Migration
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
            $table->unsignedBigInteger(Model::FIELD_ID_USER);
            $table->foreign(Model::FIELD_ID_USER)->references(Model::FIELD_ID_USER)->on(\App\Models\User::TABLE_NAME)->onDelete('cascade');
            $table->string(Model::FIELD_DETAILS);
            $table->dateTime(Model::FIELD_DATE);
            $table->unsignedSmallInteger(Model::FIELD_HOURS)->nullable();
            $table->unsignedSmallInteger(Model::FIELD_EST_HOURS);
            $table->timestamps();
            $table->unique([
                Model::FIELD_ID_USER,
                Model::FIELD_DETAILS,
                Model::FIELD_DATE,
                Model::FIELD_HOURS,
                Model::FIELD_EST_HOURS,
            ]);
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
