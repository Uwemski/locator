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
        Schema::create('parish', function (Blueprint $table) {
            $table->id();
    $table->string('name');
    $table->string('address');
    $table->string('city');
    $table->string('state');
    $table->string('pastor_name')->nullable();
    $table->string('email');
    $table->string('contact_no')->nullable();
    $table->string('website')->nullable();
    $table->decimal('latitude', 10, 8)->nullable();
    $table->decimal('longitude', 10, 9)->nullable();

    $table->unsignedBigInteger('admin_id'); // <- This is the proper foreign key
    $table->foreign('admin_id')->references('id')->on('admin')->onDelete('cascade');

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parish');
    }
};
