<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentLogs extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'id_content_logs';
    protected $table = 'content_logs';
}
