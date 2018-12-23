<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeHolidaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_holidays', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->string('occasion')->default('Office Holiday');
            $table->string('holiday_for')->default('ALL');
            $table->string('background_color')->default('blue');
            $table->string('text_color')->default('white');
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
        Schema::dropIfExists('office_work_hours');
    }
}
