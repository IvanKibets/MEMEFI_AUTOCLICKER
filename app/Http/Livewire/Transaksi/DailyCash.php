<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\DailyCash as DailyCashModel;
use App\Models\Transaksi;

class DailyCash extends Component
{
    public $insert=true,$cash_pos,$cash_start,$cash_end,$find,$daily_cash,$ct_vs_dc,$message='';
    public $filter_month;
    public function render()
    {
        $data = DailyCashModel::orderBy('id','DESC');

        if($this->filter_month)
            $data->whereMonth('cash_date',$this->filter_month)->whereYear('cash_date',date('Y'));
        else
            $data->whereMonth('cash_date',date('m'))->whereYear('cash_date',date('Y'));

        return view('livewire.transaksi.daily-cash')->with(['data'=>$data->get()]);
    }

    public function mount()
    {
        $this->cash_pos = Transaksi::where('status',1)->whereDate('created_at',date('Y-m-d'))->sum('amount');
        
        $this->find = DailyCashModel::whereDate('cash_date',date('Y-m-d'))->first();
        
        if($this->find) {
            $this->cash_start = $this->find->cash_start;
            $this->cash_end = $this->find->cash_end;
            $this->daily_cash = $this->find->daily_cash;
        }
    }

    public function updated($propertyName)
    {
        if($this->cash_end and $this->cash_start) 
            $this->daily_cash = $this->cash_end - $this->cash_start;

        if($this->cash_pos and $this->daily_cash){
            $this->ct_vs_dc = $this->daily_cash - $this->cash_pos;
        }
    }

    public function save()
    {
        if(!$this->find)
            $data = new DailyCashModel();
        else
            $data = $this->find;

        $data->cash_date = date('Y-m-d');
        $data->cash_transaction_pos = $this->cash_pos;
        $data->cash_start = $this->cash_start;
        $data->cash_end = $this->cash_end;
        $data->daily_cash = $this->daily_cash;
        $data->ct_vs_dc = $this->ct_vs_dc;
        $data->save();

        $this->message = 'Updated...';
    }
}
