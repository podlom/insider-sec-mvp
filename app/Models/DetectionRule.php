<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DetectionRule extends Model {
  use HasFactory;
  public $incrementing=false; protected $keyType='string';
  protected $fillable=['name','description','weight','severity','enabled','conditions'];
  protected $casts=['conditions'=>'array','enabled'=>'boolean'];
}
