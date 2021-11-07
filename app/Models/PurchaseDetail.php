<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    
    protected $table = 'purchase_detail';
    protected $guarded = ['id'];
    protected $with = ['product', 'purchase'];
    
    public function product()
    {
      return $this->belongsTo(Product::class);
    }
    
    public function purchase()
    {
      return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
