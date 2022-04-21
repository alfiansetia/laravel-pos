<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id', 'user_id', 'total_item', 'total_harga', 'diskon', 'bayar', 'diterima', 'kode_penj'
    ];

    public function penjualan_detail()
    {
        return $this->hasMany(Penjualan_detail::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
