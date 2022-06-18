<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContentLogs;
use App\Models\ContentSite;
use App\Models\ContentTags;
use App\Models\ContentUser;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $content = Http::get('https://sorot.news/api/data-berita/poltara')->body();
        // $ret['data'] = json_decode($content, true)['data'];

        $ret['data'] = ContentUser::leftJoin('users', 'users.id', 'content_user.id_users')
            ->leftJoin('content_logs', 'content_logs.id_content_user', 'content_user.id_content_user')
            ->orderBy('content_user.id_content_user', 'DESC')
            ->get();

        return view('content/index', $ret);
    }

    public function add()
    {
        $ret['kategori'] = Category::all();
        $ret['situs'] = Site::all();

        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            $ret['draft'] = ContentUser::where('is_draft', 1)
                ->orderBy('tanggal_publish', 'DESC')
                ->simplePaginate(6);

            $ret['terbit'] = ContentUser::whereNull('is_draft')
                ->orderBy('tanggal_publish', 'DESC')
                ->simplePaginate(6);

            $draft = ContentUser::where('is_draft', 1)
                ->orderBy('tanggal_publish', 'DESC')
                ->get();

            $terbit = ContentUser::whereNull('is_draft')
                ->where('status_content', 2)
                ->orderBy('tanggal_publish', 'DESC')
                ->get();
        } else {
            $ret['draft'] = ContentUser::where('is_draft', 1)
                ->where('id_users', Auth::user()->id)
                ->orderBy('tanggal_publish', 'DESC')
                ->simplePaginate(6);

            $ret['terbit'] = ContentUser::whereNull('is_draft')
                ->where('id_users', Auth::user()->id)
                ->orderBy('tanggal_publish', 'DESC')
                ->simplePaginate(6);

            $draft = ContentUser::where('is_draft', 1)
                ->where('id_users', Auth::user()->id)
                ->orderBy('tanggal_publish', 'DESC')
                ->get();

            $terbit = ContentUser::whereNull('is_draft')
                ->where('id_users', Auth::user()->id)
                ->where('status_content', 2)
                ->orderBy('tanggal_publish', 'DESC')
                ->get();
        }

        $ret['count_terbit'] = count($terbit);
        $ret['count_draft'] = count($draft);

        return view('content.add', $ret);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi',
            'min' => ':attribute harus diisi minimal :min karakter',
            'max' => ':attribute harus diisi maksimal :max karakter',
        ];

        $this->validate($request, [
            'judul'  => 'required|max:255',
            'isi_content' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        // Image 
        $image = $request->file('gambar');
        if ($image) {
            $image = time() . '.' . request()->gambar->getClientOriginalExtension();
            request()->gambar->move(public_path('/img/content/'), $image);
        }

        $slug = Str::slug($request->judul);
        $tags = explode(',', $request->input('tags'));

        // Data to be stored
        $insert = $request->except('_token', '_method', 'id_situs', 'tags');
        $insert['id_users'] = Auth::id();
        $insert['gambar'] = $image;
        $insert['slug'] = $slug;
        $insert['status_content'] = Auth::user()->role == 1 || Auth::user()->role == 2 ? 2 : 1;

        if (empty($insert['tanggal_publish'])) {
            $insert['tanggal_publish'] = Auth::user()->role == 1 || Auth::user()->role == 2 ? date('Y-m-d H:i:s') : '';
        }

        try {
            DB::beginTransaction();

            $content_id = ContentUser::insertGetId($insert); // Store data

            if ($content_id) {
                foreach ($request->input('id_situs') as $val) {
                    $insertSitus = [
                        'id_content' => $content_id,
                        'id_situs' => $val
                    ];

                    ContentSite::insert($insertSitus); // Store data
                }

                // Create Logs
                $insertLogs = [
                    'id_content_user' => $content_id
                ];

                ContentLogs::insert($insertLogs); // Store data
            }

            foreach ($tags as $val) {
                $insertTags = [
                    'nama_tag' => $val,
                    'id_content' => $content_id
                ];

                ContentTags::insert($insertTags); // Store data
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect('content');
    }

    public function edit($id)
    {
        $ret['data'] = ContentUser::leftJoin('kategori', 'kategori.id_kategori', 'content_user.kategori_id')
            ->leftJoin('content_situs', 'content_situs.id_content', 'content_user.id_content_user')
            ->where('content_user.id_content_user', $id)
            ->selectRaw('content_user.*, content_situs.id_situs AS id_situs')
            ->first();

        $ret['situs'] = Site::all();
        $ret['tags'] = ContentTags::where('id_content', $id)
            ->get();
        $ret['kategori'] = Category::all();

        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            $ret['draft'] = ContentUser::where('is_draft', 1)
                ->orderBy('tanggal_publish', 'DESC')
                ->simplePaginate(6);

            $ret['terbit'] = ContentUser::whereNull('is_draft')
                ->where('status_content', 2)
                ->orderBy('tanggal_publish', 'DESC')
                ->simplePaginate(6);

            $draft = ContentUser::where('is_draft', 1)
                ->orderBy('tanggal_publish', 'DESC')
                ->get();

            $terbit = ContentUser::whereNull('is_draft')
                ->where('status_content', 2)
                ->orderBy('tanggal_publish', 'DESC')
                ->get();
        } else {
            $ret['draft'] = ContentUser::where('is_draft', 1)
                ->where('id_users', Auth::user()->id)
                ->orderBy('tanggal_publish', 'DESC')
                ->simplePaginate(6);

            $ret['terbit'] = ContentUser::whereNull('is_draft')
                ->where('id_users', Auth::user()->id)
                ->where('status_content', 2)
                ->orderBy('tanggal_publish', 'DESC')
                ->simplePaginate(6);

            $draft = ContentUser::where('is_draft', 1)
                ->where('id_users', Auth::user()->id)
                ->orderBy('tanggal_publish', 'DESC')
                ->get();

            $terbit = ContentUser::whereNull('is_draft')
                ->where('id_users', Auth::user()->id)
                ->where('status_content', 2)
                ->orderBy('tanggal_publish', 'DESC')
                ->get();
        }

        $ret['count_terbit'] = count($terbit);
        $ret['count_draft'] = count($draft);

        return view('content/edit', $ret);
    }

    public function update(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi',
            'min' => ':attribute harus diisi minimal :min karakter',
            'max' => ':attribute harus diisi maksimal :max karakter',
        ];

        $this->validate($request, [
            'judul'  => 'required|max:255',
            'isi_content' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        // Image
        $image = $request->file('gambar');
        if ($image) {
            $image = time() . '.' . request()->gambar->getClientOriginalExtension();
            request()->gambar->move(public_path('/img/content/'), $image);
            $insert['gambar'] = $image;
        }

        $slug = Str::slug($request->judul);
        $tags = explode(',', $request->input('tags'));

        // Data to be updated
        $insert = $request->except('_token', '_method', 'id_situs', 'tags');
        $insert['slug'] = $slug;
        $insert['status_content'] = Auth::user()->role == 1 || Auth::user()->role == 2 ? 2 : 1;
        $insert['tanggal_publish'] = Auth::user()->role == 1 || Auth::user()->role == 2 ? date('Y-m-d H:i:s') : '';

        try {
            DB::beginTransaction();

            ContentUser::where('id_content_user', $insert['id_content_user'])->update($insert); // Update data

            if ($insert['is_draft'] == 1) { // To be drafted
                ContentSite::where('id_content', $insert['id_content_user'])->delete(); // Delete data

                foreach ($request->input('id_situs') as $val) {
                    $insertSitus = [
                        'id_content' => $insert['id_content_user'],
                        'id_situs' => $val
                    ];

                    ContentSite::insert($insertSitus); // Insert new data
                }

                ContentTags::where('id_content', $insert['id_content_user'])->delete(); // Delete data

                foreach ($tags as $val) {
                    $insertTags = [
                        'nama_tag' => $val,
                        'id_content' => $insert['id_content_user']
                    ];

                    ContentTags::insert($insertTags); // Insert new data
                }
            } else { // To be published
                ContentSite::where('id_content', $insert['id_content_user'])->delete(); // Delete data

                foreach ($request->input('id_situs') as $val) {
                    $insertSitus = [
                        'id_content' => $insert['id_content_user'],
                        'id_situs' => $val
                    ];

                    ContentSite::insert($insertSitus); // Insert new data
                }

                ContentTags::where('id_content', $insert['id_content_user'])->delete(); // Delete data

                foreach ($tags as $val) {
                    $insertTags = [
                        'nama_tag' => $val,
                        'id_content' => $insert['id_content_user']
                    ];

                    ContentTags::insert($insertTags); // Insert new data
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return redirect('content');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            $is_draft = $request->get('is_draft');

            if ($is_draft) {
                if (!empty($query)) {
                    $data = ContentUser::leftJoin('kategori', 'kategori.id_kategori', 'content_user.kategori_id')
                        ->leftJoin('content_situs', 'content_situs.id_content', 'content_user.id_content_user')
                        ->where('content_user.judul', 'like', '%' . $query . '%')
                        ->whereNotNull('is_draft')
                        ->selectRaw('content_user.*, content_situs.id_situs AS id_situs')
                        ->get();
                } else {
                    $data = ContentUser::whereNotNull('is_draft')
                        ->orderBy('tanggal_publish', 'DESC')
                        ->simplePaginate(6);
                }
            } else {
                if (!empty($query)) {
                    $data = ContentUser::leftJoin('kategori', 'kategori.id_kategori', 'content_user.kategori_id')
                        ->leftJoin('content_situs', 'content_situs.id_content', 'content_user.id_content_user')
                        ->where('content_user.judul', 'like', '%' . $query . '%')
                        ->whereNull('is_draft')
                        ->selectRaw('content_user.*, content_situs.id_situs AS id_situs')
                        ->get();
                } else {
                    $data = ContentUser::whereNull('is_draft')
                        ->orderBy('tanggal_publish', 'DESC')
                        ->simplePaginate(6);
                }
            }
        }

        $total_row = $data->count();

        if ($total_row > 0) {
            foreach ($data as $card) {
                $output .= '<div class="card card-body border-bottom"><a href="{{ url("edit") }}/' . $card->id_content_user . '" class="stretched-link judul-terbit-content" style="color: inherit;">' . $card->judul . '</a><p class="mb-0 mt-2 tanggal-terbit-content" style="font-size: 11px; opacity: 0.6;">' . date_format($card->created_at, 'd M Y H:i') . '"</p></div>';
            }
        } else {
            $output = "<div class='card card-body border-bottom'>No Data Found</div>";
        }

        $response = array(
            'data' => $output,
            'total_data' => $total_row
        );

        return response($response);
    }

    public function getCategory(Request $request)
    {
        $data = $request->all();

        if (!empty($data['id_situs'])) {
            $kategori = Category::where('id_situs', $data['id_situs'])->get();
        } else {
            $kategori = Category::whereNull('id_situs')->get();
        }

        if ($kategori) {
            $result['status'] = true;
            $result['message'] = 'Berhasil mendapatkan kategori';
            $result['data'] = $kategori;
        } else {
            $result['status'] = false;
            $result['message'] = 'Gagal mendapatkan kategori';
            $result['data'] = array();
        }

        return response($result);
    }
}
