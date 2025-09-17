<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class MetricsSnapshot extends Model {
  use HasFactory;
  public $incrementing=false;
  protected $primaryKey='date';
  protected $keyType='string';
  protected $fillable=['date','incidents_total','incidents_p1','median_mttd_minutes','median_mttr_minutes','loss_estimated_total','mfa_coverage_pct'];
}
