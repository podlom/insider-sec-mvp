<?php

use Illuminate\Support\Facades\Route;
use App\Models\SecurityEvent;
use App\Services\Rules\RuleEvaluator;
use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/v1/events', function (Request $request, RuleEvaluator $evaluator) {
        $data = $request->validate([
            'source' => 'required|string',
            'event_type' => 'required|string',
            'employee_email' => 'nullable|email',
            'asset_name' => 'nullable|string',
            'payload' => 'nullable|array',
            'occurred_at' => 'required|date',
        ]);

        $employee = $data['employee_email']
            ? App\Models\Employee::firstOrCreate(['email' => $data['employee_email']], ['name'=>$data['employee_email']])
            : null;
        $asset = $data['asset_name']
            ? App\Models\Asset::firstOrCreate(['name' => $data['asset_name']], ['type'=>'file_share','sensitivity'=>3])
            : null;

        $event = SecurityEvent::create([
            'employee_id' => $employee?->id,
            'asset_id' => $asset?->id,
            'source' => $data['source'],
            'event_type' => $data['event_type'],
            'payload' => $data['payload'] ?? [],
            'occurred_at' => $data['occurred_at'],
        ]);

        $evaluator->evaluate($event);

        return response()->json(['status' => 'ok', 'id' => $event->id]);
    });
});
