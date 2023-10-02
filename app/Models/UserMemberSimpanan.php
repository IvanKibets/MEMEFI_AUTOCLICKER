<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JenisSimpanan;

class UserMemberSimpanan extends Model
{
    use HasFactory;

    protected $table = 'user_member_simpanan';
    protected $guarded = [];
    public function jenis_simpanan()
    {
        return $this->hasOne(JenisSimpanan::class,'id','jenis_simpanan_id');
    }
}
