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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('positions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('office_type', ['Pusat', 'Regional', 'Cabang', 'Unit'])->default('Pusat');
            $table->enum('work_type', ['Dalam', 'Lapangan'])->default('Dalam');
            $table->boolean('status')->default(true);
            $table->integer('sort')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
