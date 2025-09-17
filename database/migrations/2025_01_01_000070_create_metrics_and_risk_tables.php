<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('metrics_snapshots', function (Blueprint $t) {
            $t->date('date')->primary();
            $t->unsignedInteger('incidents_total');
            $t->unsignedInteger('incidents_p1');
            $t->unsignedInteger('median_mttd_minutes')->nullable();
            $t->unsignedInteger('median_mttr_minutes')->nullable();
            $t->decimal('loss_estimated_total', 14, 2)->default(0);
            $t->unsignedTinyInteger('mfa_coverage_pct')->default(0);
            $t->timestamps();
        });

        Schema::create('risk_register', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('title');
            $t->enum('category', ['insider','availability','integrity','confidentiality','compliance','supply_chain']);
            $t->unsignedTinyInteger('likelihood');
            $t->unsignedTinyInteger('impact');
            $t->unsignedTinyInteger('rating');
            $t->text('treatment')->nullable();
            $t->enum('status', ['identified','accepted','mitigating','transferred','closed'])->index();
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('risk_register');
        Schema::dropIfExists('metrics_snapshots');
    }
};
