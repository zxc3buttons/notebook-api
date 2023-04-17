<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notebook extends Model
{
    use HasFactory;

    protected $table = 'notebooks';

    protected $primaryKey = 'id';

    protected $fillable = [
        'full_name',
        'company',
        'phone',
        'email',
        'birth_date',
        'image_link'
    ];
}
