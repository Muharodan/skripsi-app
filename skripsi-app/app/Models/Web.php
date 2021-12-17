<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Web extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama_web',
        'broken_link',
        'page_load_time',
        'size_web',
        'id_kategori'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id', 'id_kategori');;
    }
}
