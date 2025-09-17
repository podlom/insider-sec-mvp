<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('controls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('family', ['access','audit','config','ir','protect','detect','recover']);
            $table->text('objective')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('control_tests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('control_id')->index();
            $table->date('tested_on');
            $table->boolean('passed');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('control_tests');
        Schema::dropIfExists('controls');
    }
};
