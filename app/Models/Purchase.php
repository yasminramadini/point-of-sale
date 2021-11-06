<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    
    protected $table = 'purchases';
    protected $guarded = ['id'];
    
    public function supplier()
    {
      return $this->belongsTo(Supplier::class);
    }
    
    public function purchase_detail()
    {
      return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }
}
