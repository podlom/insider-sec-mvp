<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->index();
            $table->enum('status', ['new', 'triage', 'investigating', 'contained', 'resolved', 'false_positive'])->index();
            $table->uuid('employee_id')->nullable()->index();
            $table->uuid('asset_id')->nullable()->index();
            $table->timestamp('detected_at')->index();
            $table->timestamp('contained_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->decimal('estimated_loss', 14, 2)->default(0);
            $table->json('context')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
