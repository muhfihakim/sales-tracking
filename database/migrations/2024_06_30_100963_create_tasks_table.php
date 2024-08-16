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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_id')->constrained('users')->onDelete('cascade');
            $table->string('product_id');
            $table->integer('qty')->default(0);
            $table->string('outlet_id');
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
            $table->string('deskripsi')->nullable();
            $table->string('status')->default('Pending');
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
        Schema::dropIfExists('tasks');
    }
};
