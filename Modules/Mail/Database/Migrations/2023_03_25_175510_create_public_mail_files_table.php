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
        Schema::create('public_mail_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mail_id')->constrained('mails')->onUpdate('cascade')->onDelete('cascade');
            $table->text('file_path');
            $table->bigInteger('file_size');
            $table->string('file_type');
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_mail_files');
    }
};
