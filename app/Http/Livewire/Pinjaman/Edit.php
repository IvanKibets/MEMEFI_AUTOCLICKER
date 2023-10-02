<?php

namespace App\Http\Livewire\Pinjaman;

use Livewire\Component;
use App\Models\Pinjaman;
use App\Models\PinjamanItem;

class Edit extends Component
{
    public $data,$selected_id,$payment_date,$metode_pembayaran_,$note;
    protected $listeners = ['reload'=>'$refresh'];
    public function render()
    {
        return view('livewire.pinjaman.edit');
    }

    public function mount(Pinjaman $data)
    {
        $this->data = $data;
        $this->payment_date = date('Y-m-d');
    }

    public function approve()
    {
        $this->data->note = $this->note;
        $this->data->status = 1; // Approved
        $this->data->save();

        session()->flash('message-success',__('Pinjaman berhasil proses.'));

        return redirect()->route('pinjaman.edit',$this->data->id);
    }

    public function reject()
    {
        $this->data->note = $this->note;
        $this->data->status = 3; // Rejected
        $this->data->save();

        session()->flash('message-success',__('Pinjaman berhasil proses.'));

        return redirect()->route('pinjaman.edit',$this->data->id);
    }

    public function lunas()
    {
        $this->validate(
            [
                'payment_date'=>'required',
                'metode_pembayaran_'=>'required'
            ]);

        PinjamanItem::find($this->selected_id)->update([
            'status'=>1,
            'payment_date'=>$this->payment_date,
            'metode_pembayaran'=>$this->metode_pembayaran_]);
        
        $count = PinjamanItem::where(['pinjaman_id'=>$this->data->id,'status'=>0])->count();
        /**
         * Jika semua cicilan lunas maka status berubah jadi complete
         */
        if($count==0){
            $this->data->status = 2; // Lunas
            $this->data->save();
        }

        session()->flash('message-success',__('Pembayaran berhasil proses.'));

        return redirect()->route('pinjaman.edit',$this->data->id);
    }
}
