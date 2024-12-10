<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    // Tambahkan properti yang diperlukan, seperti fillable atau guarded
    protected $fillable = ['title', 'start_time'];

    // Jika menggunakan timestamps, pastikan properti ini ada
    public $timestamps = true;
}
