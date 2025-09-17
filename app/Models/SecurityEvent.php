<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class SecurityEvent extends Model {
  use HasFactory;
  public $incrementing=false; protected $keyType='string';
  protected $fillable=['employee_id','asset_id','source','event_type','payload','occurred_at'];
  protected $casts=['payload'=>'array','occurred_at'=>'datetime'];
  public function employee(){ return $this->belongsTo(Employee::class); }
  public function asset(){ return $this->belongsTo(Asset::class); }
}
