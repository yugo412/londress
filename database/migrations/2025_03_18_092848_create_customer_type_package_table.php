<?php

use App\Models\CustomerType;
use App\Models\Package;
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
        Schema::create('customer_type_package', function (Blueprint $table): void {
            $table->foreignIdFor(CustomerType::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Package::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_type_package');
    }
};
