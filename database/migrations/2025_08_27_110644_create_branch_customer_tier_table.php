<?php

use App\Models\Branch;
use App\Models\CustomerTier;
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
        Schema::create('branch_customer_tier', function (Blueprint $table): void {
            $table->foreignIdFor(Branch::class)->constrained();
            $table->foreignIdFor(CustomerTier::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_customer_tier');
    }
};
