<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('type', ['db', 'repo', 'saas', 'file_share', 'endpoint'])->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->date('purchased_at')->nullable();
            $table->decimal('cost', 12, 2)->nullable();
            $table->enum('status', ['in_stock', 'assigned', 'retired', 'lost'])->default('in_stock');
            $table->foreignId('assigned_to_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->unsignedTinyInteger('sensitivity')->default(1);
            $table->string('owner_department')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
