<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDocument extends Model
{
    use HasFactory, SoftDeletes;

    // Table name (optional, if different from plural model name)
    protected $table = 'user_documents';

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'document_name',
        'document_file',
        'expiring_date'
    ];
}
