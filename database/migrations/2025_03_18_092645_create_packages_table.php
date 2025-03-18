<?php

use App\Models\Branch;
use App\Models\Unit;
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
        Schema::create('packages', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Branch::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignIdFor(Unit::class)
                ->constrained()
                ->restrictOnDelete();
            $table->string('name', 100);
            $table->string('description')->nullable();
            $table->decimal('price');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
