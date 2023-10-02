<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductUom;
use App\Models\Product;

class SupplierProduct extends Model
{
    use HasFactory;
    protected $table = 'supplier_product';
    protected $guarded = [];  

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function uom()
    {
        return $this->hasOne(ProductUom::class,'id','product_uom_id');
    }
}