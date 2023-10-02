<?php

namespace App\Http\Livewire\JenisPinjaman;

use Livewire\Component;
use App\Models\JenisPinjaman;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $insert=false,$name,$margin=0,$selected_id,$edit=false;
    public $biaya_admin,$asuransi;
    public function render()
    {
        $data = JenisPinjaman::orderBy('id','DESC');

        return view('livewire.jenis-pinjaman.index')->with(['data'=>$data->paginate(100)]);
    }

    public function save()
    {
        $this->validate([
            'name'=>'required',
            'margin'=>'required',
            'biaya_admin'=>'required'
        ]);

        if($this->selected_id)
            $data = JenisPinjaman::find($this->selected_id);
        else
            $data = new JenisPinjaman();

        $data->name = $this->name;
        $data->margin = $this->margin;
        $data->biaya_admin = $this->biaya_admin;
        $data->asuransi = $this->asuransi;
        $data->save();

        $this->insert = false;
        $this->reset(['name','margin','biaya_admin','asuransi','selected_id']);
    }

    public function set_edit($id)
    {
        $this->selected_id = $id;
        
        $data = JenisPinjaman::find($id);

        $this->name = $data->name;
        $this->margin = $data->margin;
        $this->biaya_admin = $data->biaya_admin;
        $this->asuransi = $data->asuransi;
        $this->edit = true;
    }
}