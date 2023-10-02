<?php

namespace App\Http\Livewire\Pinjaman;

use Livewire\Component;
use App\Models\Pinjaman;
use App\Models\PinjamanItem;

class Index extends Component
{
    public $selected_id;
    public function render()
    {
        $data = Pinjaman::orderBy('id','DESC');
        
        $total_pengajuan = clone $data;
        $total_pengajuan_nominal = clone $data;
        $total_pengajuan_disetujui = clone $data;
        $total_pengajuan_ditolak = clone $data;

        return view('livewire.pinjaman.index')->with(['data'=>$data->paginate(100),
                    'total_pengajuan'=>$total_pengajuan->count(),
                    'total_pengajuan_nominal'=>$total_pengajuan_nominal->sum('amount'),
                    'total_pengajuan_disetujui'=>$total_pengajuan_disetujui->where(function($table){
                        $table->where('status',1)->orWhere('status',2);
                    })->sum('amount'),
                    'total_pengajuan_ditolak'=>$total_pengajuan_ditolak->where('status',3)->sum('amount')
                ]);
    }

    public function delete()
    {
        if($this->selected_id=="") return;

        Pinjaman::find($this->selected_id)->delete();
        PinjamanItem::where('pinjaman_id',$this->selected_id)->delete();

        session()->flash('message-success',__('Pinjaman berhasil dibatalkan.'));

        return redirect()->route('pinjaman.index');
    }
}
