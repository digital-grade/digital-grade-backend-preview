<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->string('nip')->primary();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->text('address');
            $table->string('blood_type');
            $table->string('profile_picture_url')->nullable();

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
        Schema::dropIfExists('teachers');
    }
}
