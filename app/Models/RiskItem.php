<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class RiskItem extends Model {
  use HasFactory;
  protected $table='risk_register';
  public $incrementing=false; protected $keyType='string';
  protected $fillable=['title','category','likelihood','impact','rating','treatment','status'];
}
