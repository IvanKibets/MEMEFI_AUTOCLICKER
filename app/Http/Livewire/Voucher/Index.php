<?php

namespace App\Http\Livewire\Voucher;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Voucher;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $file;
    public $is_insert=false,$voucher_number,$amount,$filter_voucher_number;
    public function render()
    {
        $data = Voucher::orderBy('id','DESC');
        
        if($this->filter_voucher_number) $data->where('voucher_number','LIKE',"%{$this->filter_voucher_number}%");

        return view('livewire.voucher.index')->with(['data'=>$data->paginate(100)]);
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        $this->voucher_number = $randomString;
    }

    public function save()
    {
        $this->validate([
            'voucher_number'=>'required',
            'amount'=>'required'
        ]);

        $data = new Voucher();
        $data->voucher_number = $this->voucher_number;
        $data->amount = $this->amount;
        $data->save();

        $this->is_insert = false;
    }

    public function upload()
    {
        ini_set('memory_limit', '-1');
        $this->validate([
            'file'=>'required|mimes:xls,xlsx|max:51200' // 50MB maksimal
        ]);
        
        $path = $this->file->getRealPath();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $data = $reader->load($path);
        $sheetData = $data->getActiveSheet()->toArray(null, true, false, true);

        if(count($sheetData) > 0){
            $countLimit = 1;
            foreach($sheetData as $key => $i){
                if($key<=1 || $i['A']=="") continue; // skip header
            
                $voucher_number = $i['A'];
                $amount = $i['B'];
                $voucher = Voucher::where('voucher_number',$voucher_number)->first();

                if(!$voucher){
                    $voucher = new Voucher();
                    $voucher->voucher_number = $voucher_number;
                    $voucher->amount = $amount;
                    $voucher->save();
                }
            }
        }

        session()->flash('message-success',__('Data berhasil di upload'));

        return redirect()->route('voucher.index');
    }
}
