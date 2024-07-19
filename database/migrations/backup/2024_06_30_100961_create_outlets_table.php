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
        Schema::create('outlets', function (Blueprint $table) {
            $table->string('id')->primary(); // Pastikan kolom id ada dan menjadi primary key
            $table->string('nama');
            $table->text('alamat');
            $table->decimal('latitude', 10, 7); // Decimal precision for latitude
            $table->decimal('longitude', 10, 7); // Decimal precision for longitude
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
        Schema::dropIfExists('outlets');
    }
};
