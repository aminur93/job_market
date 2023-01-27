<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_certifications', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('organization_name')->nullable();
            $table->string('certificate_name')->nullable();
            $table->string('certificate_area')->nullable();
            $table->date('certificate_date')->nullable();
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
        Schema::dropIfExists('customer_certifications');
    }
}
