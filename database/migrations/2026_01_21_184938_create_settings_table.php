<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('My Shop');
            $table->string('currency')->default('USD');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            $table->string('contact_number')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('address')->nullable();

            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('whatsapp')->nullable();

            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();

            $table->string('team_name')->nullable();
            $table->string('copyright_text')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
