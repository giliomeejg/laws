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
        Schema::create('laws', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('law_url');
            $table->integer('number_of_words')->nullable();
            $table->integer('nr_errors')->default(0);
            $table->datetime('last_error_at')->nullable();
            $table->datetime('approve_at')->nullable();
            $table->datetime('processed_at')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('laws');
    }
};
