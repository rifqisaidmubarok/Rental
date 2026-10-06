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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();

        $table->foreignId('category_id')
            ->constrained('vehicle_categories')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->string('code')->unique();
        $table->string('name');
        $table->string('brand');
        $table->string('plate_number')->unique();
        $table->year('year');
        $table->decimal('price_per_day', 12, 2);
        $table->enum('status', ['tersedia', 'disewa', 'servis'])
            ->default('tersedia');
        $table->text('description')->nullable();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
