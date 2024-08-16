<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; // Tentukan kolom primary key

    public $incrementing = false; // Primary key tidak di-increment

    protected $keyType = 'string'; // Jenis primary key adalah string

    protected $fillable = [
        'id',
        'nama_produk',
        'qty',
        'harga',
        'gambar',
    ];
}
