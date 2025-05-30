<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_properties_table.php

public function up()
{
    Schema::create('properties', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('status')->default('active');
        $table->decimal('price', 10, 2);
        $table->string('location');
        $table->string('image')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
