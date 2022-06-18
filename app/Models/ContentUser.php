<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentUser extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'id_content_user';
    protected $table = 'content_user';
}
