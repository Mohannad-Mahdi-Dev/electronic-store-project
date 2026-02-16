<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
