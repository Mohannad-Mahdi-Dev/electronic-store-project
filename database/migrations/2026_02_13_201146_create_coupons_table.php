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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // كود الخصم مثل: SAVE20
            $table->enum('type', ['fixed', 'percent']); // خصم مبلغ ثابت أو نسبة مئوية
            $table->decimal('value', 10, 2); // قيمة الخصم
            $table->decimal('cart_value', 10, 2)->nullable(); // الحد الأدنى للسلة لتفعيل الخصم
            $table->date('expiry_date')->nullable(); // تاريخ الانتهاء
            $table->integer('usage_limit')->nullable(); // أقصى عدد مرات استخدام
            $table->integer('used_count')->default(0); // كم مرة استُخدم فعلياً
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
