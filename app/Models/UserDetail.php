<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    use HasFactory , SoftDeletes;


    // Table name (optional, if different from plural model name)
    protected $table = 'user_details';

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'ni_number',
        'utr_number',
        'refrence_name',
        'refrence_phone',
        'refrence_realtion',
        'Joing_date',
        'base_salary'
    ];
}
