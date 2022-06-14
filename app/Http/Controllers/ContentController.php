<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContentController extends Controller
{
    public function index()
    {
        $content = Http::get('https://sorot.news/api/data-berita/poltara')->body();
        $ret['data'] = json_decode($content, true)['data'];

        return view('content/index', $ret);
    }
}
