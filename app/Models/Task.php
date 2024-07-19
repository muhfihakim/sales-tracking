<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'outlet_id',
        'deskripsi',
        'status',
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function getDistanceAttribute()
    {
        $lastLocation = $this->sales->last_location;
        if ($lastLocation) {
            return $lastLocation->calculateDistance($this->outlet->latitude, $this->outlet->longitude);
        }
        return null;
    }
}
