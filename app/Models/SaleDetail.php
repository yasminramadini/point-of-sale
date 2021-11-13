<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    
    protected $table = 'sale_detail';
    protected $guarded = ['id'];
    protected $with = ['product', 'sale'];
    
    public function product()
    {
      return $this->belongsTo(Product::class);
    }
    
    public function sale()
    {
      return $this->belongsTo(Sale::class);
    }
}
