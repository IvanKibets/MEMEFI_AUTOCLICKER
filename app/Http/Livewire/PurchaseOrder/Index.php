<?php

namespace App\Http\Livewire\PurchaseOrder;

use Livewire\Component;
use App\Models\PurchaseOrder;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword,$filter=[],$total_po=0,$total_lunas=0,$total_belum_lunas=0,$selected_id;
    protected $listeners = ['refresh'=>'$refresh'];
    public function render()
    {
        $data = $this->getData();

        return view('livewire.purchase-order.index')->with(['data'=>$data->paginate(200)]);
    }

    public function mount()
    {
        $this->total_po = PurchaseOrder::whereYear('created_at',date('Y'))->sum('total_pembayaran');
        $this->total_belum_lunas = PurchaseOrder::whereYear('created_at',date('Y'))->where('status_invoice',0)->sum('total_pembayaran');
        $this->total_lunas = PurchaseOrder::whereYear('created_at',date('Y'))->where('status_invoice',1)->sum('total_pembayaran');

        \LogActivity::add('Purchase Order');
    } 

    public function getData()
    {
        $data = PurchaseOrder::orderBy('id','DESC');
        
        return $data;
    }

    public function delete()
    {
        \LogActivity::add('Purchase Order Delete #'.$this->selected_id);

        PurchaseOrder::find($this->selected_id)->delete();
        
        session()->flash('message-success',"Purchase order deleted");

        return redirect()->route('purchase-order.index');
    }

    public function insert()
    {
        $data = new PurchaseOrder();
        $data->no_po = "PO/".date('ymd')."/".str_pad((PurchaseOrder::count()+1),4, '0', STR_PAD_LEFT);
        $data->status = 0;
        $data->save();

        \LogActivity::add('Purchase Order Insert');

        return redirect()->route('purchase-order.detail',$data->id);
    }
}
