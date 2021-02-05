<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes_student', function (Blueprint $table) {
            $table->id();

            $table->string('student_nis');
            $table->foreignId('classes_id')->constrained('classes');

            $table->foreign('student_nis')->references('nis')->on('students');

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
        Schema::dropIfExists('classes_student');
    }
}
