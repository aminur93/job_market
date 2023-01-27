<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('category_id');
            $table->date('publish_date');
            $table->date('expire_date');
            $table->string('company_name');
            $table->string('position');
            $table->string('vacancy');
            $table->string('qualification');
            $table->string('location');
            $table->string('employement_status');
            $table->string('work_place');
            $table->string('salary');
            $table->string('experience');
            $table->text('company_description');
            $table->text('job_description');
            $table->text('responsibility_description');
            $table->text('additional_description');
            $table->text('other_benefits');
            $table->tinyInteger('fresher_status');
            $table->tinyInteger('approve');
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
        Schema::dropIfExists('jobs');
    }
}
