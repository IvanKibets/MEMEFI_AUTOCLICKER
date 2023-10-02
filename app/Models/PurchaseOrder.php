<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrderDetail;
use App\Models\Supplier;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $table = 'purchase_order';
    protected $guarded = [];  
    
    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class,'id_po','id')->orderBy('id','DESC');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class,'id','id_supplier');
    }
}
