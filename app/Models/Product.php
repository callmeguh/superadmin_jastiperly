<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // Kolom yang boleh mass assignment
    protected $fillable = [
        'nama_barang',
        'deskripsi_barang',
        'harga_barang',
        'foto',
        'traveler_id',
        'status',
    ];

    // Default value untuk kolom enum status
    protected $attributes = [
        'status' => 'validasi',
    ];

    // Relasi ke User (Traveler)
    public function traveler()
    {
        return $this->belongsTo(User::class, 'traveler_id');
    }
}
