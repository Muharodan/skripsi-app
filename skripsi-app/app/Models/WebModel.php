<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama_web',
        'broken_link',
        'page_load_time',
        'size_web'
    ];
}
