<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model {
    use HasFactory;
    public $incrementing=false;
    protected $keyType='string';
    protected $fillable=['email','name','department','role'];
}
