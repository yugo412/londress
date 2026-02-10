<?php

use App\Domains\Laundry\Services\Enums\ServiceUnit;
use App\Models\Branch;
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
        Schema::create('services', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Branch::class)->constrained()->restrictOnDelete();
            $table->string('name');
            $table->decimal('price', 12, 2);
            $table->string('unit')->default(ServiceUnit::Kilogram->value);
            $table->unsignedSmallInteger('estimated_days')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['branch_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
