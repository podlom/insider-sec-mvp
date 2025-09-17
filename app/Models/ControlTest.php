<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlTest extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['control_id', 'tested_on', 'passed', 'notes'];

    protected $casts = ['tested_on' => 'date', 'passed' => 'boolean'];
}
