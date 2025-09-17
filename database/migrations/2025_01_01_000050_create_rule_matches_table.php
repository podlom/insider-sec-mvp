<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rule_matches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rule_id')->index();
            $table->uuid('event_id')->index();
            $table->unsignedSmallInteger('score');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('rule_matches'); }
};
