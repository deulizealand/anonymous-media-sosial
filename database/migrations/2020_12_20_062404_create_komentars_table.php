<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komentars', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            // $table->id();
            $table->string('nama');
            $table->string('UUID')->primary();
            $table->string('UUID_Postingan');
            $table->foreign('UUID_Postingan')->references('UUID')->on('postingans')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->string('komentar');
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
        Schema::dropIfExists('komentars');
    }
}
