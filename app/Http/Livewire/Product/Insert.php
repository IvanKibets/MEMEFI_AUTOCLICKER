<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

class Insert extends Component
{
    public $kode_produksi,$keterangan,$type="Stock";
    public function render()
    {
        return view('livewire.product.insert');
    }

    public function save()
    {
        $this->validate([
            'kode_produksi' => 'required',
            'keterangan' => 'required',
            'type' => 'required'
        ]);

        $data = new Product();
        $data->kode_produksi = $this->kode_produksi;
        $data->keterangan = $this->keterangan;
        $data->type = $this->type;
        $data->save();

        session()->flash('message-success',"Product berhasil di simpan, selanjutnya kamu harus tentukan harga jual produk");

        return redirect()->route('product.detail',$data->id);
    }
}
