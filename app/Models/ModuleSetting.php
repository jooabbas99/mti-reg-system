<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleSetting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'type',
        'data',
        'validate_attr',
        'slug',
        'page'
    ];
}
