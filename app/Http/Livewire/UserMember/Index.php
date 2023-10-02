<?php

namespace App\Http\Livewire\UserMember;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UserMember;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    public $keyword,$koordinator_id,$status;
    use WithPagination;
    protected $paginationTheme = 'bootstrap',$listeners = ['set-resign'=>'setResign'];
    public $dataMember,$selected,$password,$insert=false;
    public $no_anggota,$error_no_anggota,$nama,$no_telepon,$pin;
    public $tanggal_resign,$alasan_resign,$selected_item,$type,$total_anggota=0,$total_anggota_aktif=0,$total_anggota_non_aktif=0;
    public $anggota_insert=['type'=>'','nama'=>'','no_anggota'=>'','no_telepon'=>''];
    public function render()
    {
        $data = UserMember::select('user_member.*')->join('users','users.id','=','user_member.user_id')
                            ->orderBy('user_member.id','DESC');

        if($this->keyword){
            $data->where(function($table){
                    $table->orWhere("user_member.name",'LIKE',"%{$this->keyword}%")
                        ->orWhere("user_member.no_anggota_platinum",'LIKE',"%{$this->keyword}%");
            });
        }
        
        if($this->koordinator_id) $data = $data->where('user_member.koordinator_id',$this->koordinator_id);
        if($this->status) $data = $data->where('user_member.status',$this->status);
        if($this->type) $data = $data->where('user_member.type',$this->type);
        
        $total = clone $data;
        $total_aktif = clone $data;
        $total_non_aktif = clone $data;
        $this->total_anggota = $total->count();
        $this->total_anggota_aktif = $total_aktif->where('status',1)->count();
        $this->total_anggota_non_aktif = $total_non_aktif->where('status',4)->count();

        return view('livewire.user-member.index')
                ->layout('layouts.app')
                ->with(['data'=>$data->paginate(100)]);
    }

    public function setResign(UserMember $id)
    {
        $this->selected_item = $id;
    }

    public function changeResign()
    {
        $this->selected_item->status = 4;
        $this->selected_item->alasan_resign = $this->alasan_resign;
        $this->selected_item->tanggal_resign = $this->tanggal_resign;
        $this->selected_item->save();
        $this->emit('message-success',"Data anggota berhasil disubmit");
        $this->emit('close-modal');
    }

    public function changePin()
    {
        $this->validate([
            'pin' => 'required'
        ]);
        $user = User::find($this->selected->user_id);
        if($user){
            $user->pin = \Hash::make($this->pin);
            $user->save();

            // Sinkron Coopzone
            \App\Jobs\SyncCoopzone::dispatch([
                'url'=>'koperasi/user/edit',
                'no_anggota'=>$user->username,
                'field'=>'pin',
                'value'=>$this->pin
            ]);
        }
        
        session()->flash('message-success',__('PIN berhasil dirubah'));
        
        return redirect()->to('user-member');
    }

    public function changePassword() 
    {
        $this->validate([
            'password' => 'required'
        ]);
        $user = User::find($this->selected->user_id);
        if($user){
            $user->password = \Hash::make($this->password);
            $user->username = $this->selected->no_anggota_platinum;
            $user->save();

            // Sinkron Coopzone
            \App\Jobs\SyncCoopzone::dispatch([
                'url'=>'koperasi/user/edit',
                'no_anggota'=>$user->username,
                'field'=>'password',
                'value'=>$this->password
            ]);
        }
        
        session()->flash('message-success',__('Password berhasil dirubah'));
        
        return redirect()->to('user-member');
    }
    
    public function set_member(UserMember $selected)
    {
        $this->selected = $selected;
    }

    public function delete($id)
    {
        UserMember::find($id)->delete();
        $this->emit('message-success','Data anggota berhasil dihapus');
    }

    public function save()
    {
        $this->validate([
            'anggota_insert.no_anggota'=>'required',
            'anggota_insert.nama'=>'required',
            // 'anggota_insert.no_telepon'=>'required'
        ]);

        $find = UserMember::where('no_anggota_platinum',$this->anggota_insert['no_anggota'])->first();
        if($find){
            $this->error_no_anggota = 'No Anggota sudah digunakan';
            return;
        }

        $user = new User();
        $user->user_access_id = 4; // Member
        $user->name = $this->anggota_insert['nama'];
        // $user->telepon = $this->anggota_insert['no_telepon'];
        $user->password = Hash::make('12345678');
		$user->username = $this->anggota_insert['no_anggota'];
        $user->save();

        $data = new UserMember();
     	$data->no_anggota_platinum = $this->anggota_insert['no_anggota'];
     	$data->name = $this->anggota_insert['nama'];
     	// $data->phone_number = $this->anggota_insert['no_telepon'];
        $data->user_id = $user->id;
        $data->type = $this->anggota_insert['type'];
        $data->save();

        \App\Jobs\SyncCoopzone::dispatch([
            'url'=>'koperasi/user/insert',
            'data' => [
                'nama' => $data->name,
                'no_anggota' => $data->no_anggota_platinum,
                // 'no_telepon' => $data->phone_number
            ]
        ]);

        $this->anggota_insert=['type'=>'','nama'=>'','no_anggota'=>'','no_telepon'=>''];
        $this->insert = false;
    }
    
    public function downloadExcel()
    {
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Entigi System")
                                    ->setLastModifiedBy("Entigi System")
                                    ->setTitle("Office 2007 XLSX Product Database")
                                    ->setSubject("Data Anggotaa")
                                    ->setDescription("Data Anggota")
                                    ->setKeywords("office 2007 openxml php")
                                    ->setCategory("Anggota");

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('689a3b');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'DATA ANGGOTA');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(false);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A3', 'No Anggota')
                    ->setCellValue('B3', 'Nama')
                    ->setCellValue('C3', 'Pokok')
                    ->setCellValue('D3', 'Wajib')
                    ->setCellValue('E3', 'Sukarela')
                    ->setCellValue('F3', 'Lain-lain')
                    ->setCellValue('G3', 'SHU')
                    ->setCellValue('H3', 'Tunai')
                    ->setCellValue('I3', 'Kuota')
                    ->setCellValue('J3', 'Digunakan');
                    
        $objPHPExcel->getActiveSheet()->getStyle('A3:AJ3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('c2d7f3');
        $objPHPExcel->getActiveSheet()->getStyle('A3:AJ3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AJ3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(34);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
        //$objPHPExcel->getActiveSheet()->freezePane('A4');
        $objPHPExcel->getActiveSheet()->setAutoFilter('B3:AJ3');
        $num=4;

        $data = \App\Models\UserMember::orderBy('id','DESC');
        
        foreach($data->get() as $k => $i){
        
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$num,($k+1))
                ->setCellValue('B'.$num,$i->no_anggota_platinum)
                ->setCellValue('C'.$num,$i->name)
                ->setCellValue('C'.$num,$i->simpanan_pokok)
                ->setCellValue('C'.$num,$i->simpanan_wajib)
                ->setCellValue('C'.$num,$i->simpanan_sukarela)
                ->setCellValue('C'.$num,$i->simpanan_lain_lain)
                ->setCellValue('C'.$num,$i->name)
                ;
                // ->setCellValue('AP'.$num,strip_tags(getAsuransi($i->id)));
            // $objPHPExcel->getActiveSheet()->getStyle('AG'.$num)->getNumberFormat()->setFormatCode('#,##0');
            // $objPHPExcel->getActiveSheet()->getStyle('AH'.$num)->getNumberFormat()->setFormatCode('#,##0');
            // $objPHPExcel->getActiveSheet()->getStyle('AI'.$num)->getNumberFormat()->setFormatCode('#,##0');
            // $objPHPExcel->getActiveSheet()->getStyle('AK'.$num)->getNumberFormat()->setFormatCode('#,##0');
            $num++;
        }
        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('Iuran-'. date('d-M-Y'));
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, "Xlsx");

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="anggota-' .date('d-M-Y') .'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        //header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        return response()->streamDownload(function() use($writer){
            $writer->save('php://output');
        },'anggota-' .date('d-M-Y') .'.xlsx');
    }
}
