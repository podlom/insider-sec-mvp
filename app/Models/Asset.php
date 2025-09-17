<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'serial_number',
        'purchased_at',
        'cost',
        'status',
        'assigned_to_id',
        'sensitivity',
        'owner_department',
        'notes',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'purchased_at' => 'date',
        'cost' => 'decimal:2',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
