<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSite extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'id_content_situs';
    protected $table = 'content_situs';
}
