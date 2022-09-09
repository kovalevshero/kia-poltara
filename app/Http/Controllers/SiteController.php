<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Exception;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ret['data'] = Site::all();

        return view('site.index', $ret);
    }

    public function store(Request $request)
    {
        try {
            Site::create([
                'site_name' => $request->site_name,
                'site_url' => $request->site_url
            ]);

            return redirect('site')->with(['success' => 'Berhasil menambahkan data situs']);
        } catch (Exception $e) {
            return redirect('site')->with(['error' => $e->getMessage()]);
        }
    }
}
