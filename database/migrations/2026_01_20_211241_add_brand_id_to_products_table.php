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
        Schema::table('products', function (Blueprint $table) {
            // nullable() مهم في حال كان لديك منتجات بدون ماركة
            // constrained() يربط الحقل بجدول brands
            // onDelete('set null') تعني أنه لو حُذفت ماركة، سيتم تحويل قيمة brand_id للمنتجات التابعة لها إلى NULL بدلاً من حذف المنتج
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};
