<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('inquiries')){
        Schema::create('inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_number');
            $table->string('description');
            $table->boolean('is_agent');
            $table->timestamps();
            $table->foreign('reference_number')
            ->references('reference_number')
            ->on('inquiry_h')
            ->onDelete('cascade');
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
}
