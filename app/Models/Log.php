<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'method',
        'route',
        'payload',
        'response_status'
    ];

    protected $casts = [
        'payload' => 'array' // Laravel converte JSON para array automaticamente
    ];
}
