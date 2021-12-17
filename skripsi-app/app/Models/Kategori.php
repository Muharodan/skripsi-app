<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama_kategori'
    ];

    public function web(){
        return $this->hasMany(Web::class, 'id_kategori', 'id');
    }
}
