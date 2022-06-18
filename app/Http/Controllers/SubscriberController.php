<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $ret['data'] = Subscriber::all();

        return view('subscriber.index', $ret);
    }

    public function delete($id)
    {
        $newsSubscription = Subscriber::where('id_news_subscription', $id)->delete();

        if ($newsSubscription) {
            return redirect('subscriber')->with(['success' => 'Berhasil menghapus data pelanggan']);
        } else {
            return redirect('subscriber')->with(['error' => 'Gagal menghapus data pelanggan']);
        }
    }
}
