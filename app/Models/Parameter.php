<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    protected $table = 'tparameter';

    protected $fillable = [
        'client_id',
        'name',
        'description',
        'value',
        'created_at',
        'updated_at'
    ];
}
