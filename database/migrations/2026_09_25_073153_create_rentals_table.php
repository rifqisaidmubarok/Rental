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
    Schema::create('rentals', function (Blueprint $table) {
        $table->id();

        $table->string('rental_code')->unique();

        $table->foreignId('customer_id')
            ->constrained('customers')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->date('rental_date');
        $table->date('return_date');
        $table->date('actual_return_date')->nullable();

        $table->decimal('subtotal', 12, 2)->default(0);
        $table->decimal('late_fee', 12, 2)->default(0);
        $table->decimal('total', 12, 2)->default(0);

        $table->enum('status', [
            'menunggu',
            'disewa',
            'selesai',
            'terlambat',
            'dibatalkan'
        ])->default('menunggu');

        $table->text('notes')->nullable();

        $table->foreignId('created_by')
            ->constrained('users')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
