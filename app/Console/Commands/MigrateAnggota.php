<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserMember;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MigrateAnggota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:anggota';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        $inputFileName = './public/migrasi/user-member.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, false, true);

        $arr = [];
        $key=0;
        $num=0;
        foreach($sheetData as $k =>$item){
            $num++;
            if($num<=1) continue;

            $nama = $item['B'];
            $no_anggota = $item['C'];
            $saldo = $item['D'];

            $member = UserMember::where('no_anggota_platinum',$no_anggota)->first();

            if(!$member){
                $user = new User();
                $user->user_access_id = 4; // Member
                $user->nik = $no_anggota;
                $user->name = $nama;
                $user->password = Hash::make('12345678');
                $user->username = $no_anggota;
                $user->save();
                
                $member = new UserMember();
                $member->user_id = $user->id;
            }

            $member->name = $nama;
            $member->no_anggota_platinum = $no_anggota;
            $member->plafond = $saldo;
            $member->save();

            $this->warn("{$k}. Nama : {$nama}");
        }
    }
}
