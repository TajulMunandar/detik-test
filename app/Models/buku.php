<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function kategoris()
    {
        return $this->belongsTo(kategori::class, 'kategoriId');
    }

    public function users()
    {
        return $this->belongsTo(kategori::class, 'userId');
    }
}
