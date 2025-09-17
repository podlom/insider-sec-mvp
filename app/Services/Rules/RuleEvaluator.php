<?php

namespace App\Services\Rules;

use App\Models\DetectionRule;
use App\Models\RuleMatch;
use App\Models\SecurityEvent;

class RuleEvaluator
{
    public function evaluate(SecurityEvent $event): array
    {
        $matches = [];
        $rules = DetectionRule::query()->where('enabled', true)->get();
        foreach ($rules as $rule) {
            if ($this->match($rule->conditions, $event)) {
                $score = $this->score($rule, $event);
                $matches[] = RuleMatch::create([
                    'rule_id' => $rule->id,
                    'event_id' => $event->id,
                    'score' => $score,
                ]);
            }
        }

        return $matches;
    }

    protected function match(array $conditions, SecurityEvent $event): bool
    {
        $logic = $conditions['logic'] ?? 'all';
        $conds = $conditions['rules'] ?? [];
        $results = array_map(function ($c) use ($event) {
            $field = data_get($event->toArray() + ['payload' => $event->payload], $c['field'] ?? '');
            $op = $c['op'] ?? 'eq';
            $val = $c['value'] ?? null;

            return match ($op) {
                'eq' => $field == $val, 'neq' => $field != $val,
                'gt' => $field > $val,  'gte' => $field >= $val,
                'lt' => $field < $val,  'lte' => $field <= $val,
                'in' => in_array($field, (array) $val, true),
                'regex' => is_string($field) && @preg_match($val, $field) === 1,
                'contains' => is_string($field) && is_string($val) && str_contains($field, $val),
                default => false,
            };
        }, $conds);

        return $logic === 'all' ? ! in_array(false, $results, true) : in_array(true, $results, true);
    }

    protected function score(DetectionRule $rule, SecurityEvent $event): int
    {
        $base = (int) ($rule->weight ?? 10);
        $sens = (int) optional($event->asset)->sensitivity; // 1..5

        return $base + $sens * 5;
    }
}
