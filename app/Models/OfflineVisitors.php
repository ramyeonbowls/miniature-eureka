<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineVisitors extends Model
{
    use HasFactory;

    protected $table = 'tvisitors_offline';

    protected $fillable = [
        'client_id',
        'name',
        'email',
        'date',
        'created_at',
        'updated_at'
    ];
}
