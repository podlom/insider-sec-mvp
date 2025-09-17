<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Incident extends Model {
  use HasFactory;
  public $incrementing=false; protected $keyType='string';
  protected $fillable=['title','severity','status','employee_id','asset_id','detected_at','contained_at','resolved_at','estimated_loss','context'];
  protected $casts=['detected_at'=>'datetime','contained_at'=>'datetime','resolved_at'=>'datetime','context'=>'array','estimated_loss'=>'decimal:2'];
}
