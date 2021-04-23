<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    //$fillable attribute is an array containing all those fields of table which can be filled using mass-assignment.
    protected $fillable = [
        'name',
        'file_path'
    ];
}
