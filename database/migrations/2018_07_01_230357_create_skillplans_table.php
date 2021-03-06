<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skillplans', function (Blueprint $table) {
            $table->string('id', 32);
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('attributes')->nullable();
            $table->json('remaps')->nullable();
            $table->unsignedInteger('training_time')->default(0);
            $table->unsignedInteger('total_sp')->default(0);
            $table->unsignedBigInteger('author_id')->nullable();
            $table->boolean('author_anon')->default(0);
            $table->boolean('is_public')->default(0);
            $table->timestamps();

            $table->primary('id');

            $table->index('author_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skillplans');
    }
}
