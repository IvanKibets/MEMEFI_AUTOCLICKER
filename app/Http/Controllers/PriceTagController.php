<?php

namespace App\Http\Controllers;

use App\Models\Product;

class PriceTagController extends Controller
{
    public function price_tag(Product $data)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('livewire.product.print-price-tag',['data'=>$data]);
        
        return $pdf->stream();
        // return $pdf->download('price-tag.pdf');
    }

    
}
