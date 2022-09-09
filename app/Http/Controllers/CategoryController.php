<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ret['data'] = Category::leftJoin('site', 'site.id', 'category.site_id')
            ->get();

        return view('category.index', $ret);
    }
}
