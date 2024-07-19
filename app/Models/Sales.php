<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'jenis_kendaraan',
        'plat_kendaraan',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'sales_id'); // Sesuaikan dengan foreign key yang benar
    }

    // Accessor for completed tasks
    public function getTugasSelesaiAttribute()
    {
        return $this->user->tasks->where('status', 'Selesai')->count();
    }

    // Accessor for pending tasks
    public function getTugasPendingAttribute()
    {
        return $this->user->tasks->where('status', 'Pending')->count();
    }
}
