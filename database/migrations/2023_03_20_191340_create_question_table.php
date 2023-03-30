<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table -> string('type', 50);
            $table -> string('questionDesc', 255);
            $table -> string('optionA', 255);
            $table -> string('optionB', 255);
            $table -> string('optionC', 255);
            $table -> string('answer', '1');
            $table -> integer('id_subject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
