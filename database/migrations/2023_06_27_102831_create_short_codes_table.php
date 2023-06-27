<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortCodesTable extends Migration
{
    public function up()
    {
        Schema::create('short_codes', function (Blueprint $table) {
            $table->id();
            $table->string('shortcode')->unique();
            $table->text('replace');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('short_codes');
    }
}
