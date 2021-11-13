<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    public function member()
    {
      return $this->belongsTo(Member::class);
    }
    
    public function sale_detail()
    {
      return $this->hasMany(SaleDetail::class);
    }
    
    public function user() {
      return $this->belongsTo(User::class);
    }
    
}
