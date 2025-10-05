<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model {
  protected $fillable = ['shop_domain','access_token','scope'];
  protected $casts = ['access_token' => 'encrypted'];
}