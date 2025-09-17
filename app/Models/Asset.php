<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Asset extends Model {
    use HasFactory;
    public $incrementing=false; protected $keyType='string';
    protected $fillable=['name','type','sensitivity','owner_department'];
}
