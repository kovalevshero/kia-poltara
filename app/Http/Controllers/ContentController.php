<?php

namespace App\Http\Controllers;

use App\Models\{Category, Content, ContentSite, ContentTags, Site};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function index()
    {
        $ret['data'] = Content::leftJoin('users', 'users.id', 'content.user_id')
            ->orderBy('content.id', 'DESC')
            ->selectRaw('content.*, users.*, content.id AS content_id')
            ->get();

        return view('content.index', $ret);
    }

    public function create()
    {
        $ret['category'] = Category::all();
        $ret['site'] = Site::all();

        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
            $ret['draft'] = Content::where('is_draft', 1)
                ->orderBy('published_date', 'DESC')
                ->simplePaginate(6);

            $ret['terbit'] = Content::whereNull('is_draft')
                ->orderBy('published_date', 'DESC')
                ->simplePaginate(6);

            $draft = Content::where('is_draft', 1)
                ->orderBy('published_date', 'DESC')
                ->get();

            $terbit = Content::whereNull('is_draft')
                ->where('status_content', 2)
                ->orderBy('published_date', 'DESC')
                ->get();
        } else {
            $ret['draft'] = Content::where('is_draft', 1)
                ->where('user_id', Auth::user()->id)
                ->orderBy('published_date', 'DESC')
                ->simplePaginate(6);

            $ret['terbit'] = Content::whereNull('is_draft')
                ->where('user_id', Auth::user()->id)
                ->orderBy('published_date', 'DESC')
                ->simplePaginate(6);

            $draft = Content::where('is_draft', 1)
                ->where('user_id', Auth::user()->id)
                ->orderBy('published_date', 'DESC')
                ->get();

            $terbit = Content::whereNull('is_draft')
                ->where('user_id', Auth::user()->id)
                ->where('status_content', 2)
                ->orderBy('published_date', 'DESC')
                ->get();
        }

        $ret['count_terbit'] = count($terbit);
        $ret['count_draft'] = count($draft);

        return view('content.create', $ret);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi',
            'min' => ':attribute harus diisi minimal :min karakter',
            'max' => ':attribute harus diisi maksimal :max karakter',
        ];

        $this->validate($request, [
            'title'  => 'required|max:255',
            'body' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        // dd($request->all());

        // Image 
        $image = $request->file('image');

        if ($image) {
            $image = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('/img/content/'), $image);
        }

        $slug = Str::slug($request->title);
        $tags = explode(',', $request->tags);

        // Data to be stored
        $insert = $request->except('_token', '_method', 'site_id', 'tags');
        $insert['user_id'] = Auth::id();
        $insert['image'] = $image;
        $insert['slug'] = $slug;
        $insert['status_content'] = Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ? 2 : 1;

        if (empty($insert['published_date'])) {
            $insert['published_date'] = Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ? now() : null;
        }

        try {
            DB::beginTransaction();

            $content_id = Content::insertGetId($insert); // Store data

            if ($content_id) {
                foreach ($request->site_id as $val) {
                    $insertSitus = [
                        'content_id' => $content_id,
                        'site_id' => $val
                    ];

                    ContentSite::insert($insertSitus); // Store data
                }
            }

            foreach ($tags as $val) {
                $insertTags = [
                    'tag_name' => $val,
                    'content_id' => $content_id
                ];

                ContentTags::insert($insertTags); // Store data
            }

            DB::commit();

            return redirect('content');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $ret['data'] = Content::leftJoin('category', 'category.id', 'content.category_id')
            ->leftJoin('content_site', 'content_site.content_id', 'content.id')
            ->where('content.id', $id)
            ->selectRaw('content.*, content.id AS content_id, content_site.site_id AS site_id')
            ->first();

        $ret['site'] = Site::all();

        $ret['tags'] = ContentTags::where('content_id', $id)
            ->get();

        $ret['category'] = Category::all();

        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
            $ret['draft'] = Content::where('is_draft', 1)
                ->orderBy('published_date', 'DESC')
                ->simplePaginate(6);

            $ret['terbit'] = Content::whereNull('is_draft')
                ->where('status_content', 2)
                ->orderBy('published_date', 'DESC')
                ->simplePaginate(6);

            $draft = Content::where('is_draft', 1)
                ->orderBy('published_date', 'DESC')
                ->get();

            $terbit = Content::whereNull('is_draft')
                ->where('status_content', 2)
                ->orderBy('published_date', 'DESC')
                ->get();
        } else {
            $ret['draft'] = Content::where('is_draft', 1)
                ->where('user_id', Auth::user()->id)
                ->orderBy('published_date', 'DESC')
                ->simplePaginate(6);

            $ret['terbit'] = Content::whereNull('is_draft')
                ->where('user_id', Auth::user()->id)
                ->where('status_content', 2)
                ->orderBy('published_date', 'DESC')
                ->simplePaginate(6);

            $draft = Content::where('is_draft', 1)
                ->where('user_id', Auth::user()->id)
                ->orderBy('published_date', 'DESC')
                ->get();

            $terbit = Content::whereNull('is_draft')
                ->where('user_id', Auth::user()->id)
                ->where('status_content', 2)
                ->orderBy('published_date', 'DESC')
                ->get();
        }

        $ret['count_terbit'] = count($terbit);
        $ret['count_draft'] = count($draft);

        return view('content.edit', $ret);
    }

    public function update(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib diisi',
            'min' => ':attribute harus diisi minimal :min karakter',
            'max' => ':attribute harus diisi maksimal :max karakter',
        ];

        $this->validate($request, [
            'title'  => 'required|max:255',
            'body' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);

        // dd($request->all());

        // Image
        $image = $request->file('image');

        if ($image) {
            $image = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('/img/content/'), $image);
            $insert['image'] = $image;
        }

        $slug = Str::slug($request->title);
        $tags = explode(',', $request->tags);

        // Data to be updated
        $insert = $request->except('_token', '_method', 'site_id', 'tags');
        $insert['slug'] = $slug;
        $insert['status_content'] = Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ? 2 : 1;
        $insert['published_date'] = Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ? now() : null;

        try {
            DB::beginTransaction();

            Content::where('id', $insert['id'])->update($insert); // Update data

            if ($insert['is_draft'] == 1) { // To be drafted
                Site::where('content_id', $insert['id'])->delete(); // Delete data

                foreach ($request->site_id as $val) {
                    $insertSitus = [
                        'content_id' => $insert['id'],
                        'site_id' => $val
                    ];

                    Site::insert($insertSitus); // Insert new data
                }

                ContentTags::where('content_id', $insert['id'])->delete(); // Delete data

                foreach ($tags as $val) {
                    $insertTags = [
                        'tag_name' => $val,
                        'content_id' => $insert['id']
                    ];

                    ContentTags::insert($insertTags); // Insert new data
                }
            } else { // To be published
                ContentSite::where('content_id', $insert['id'])->delete(); // Delete data

                foreach ($request->input('site_id') as $val) {
                    $insertSitus = [
                        'content_id' => $insert['id'],
                        'site_id' => $val
                    ];

                    ContentSite::insert($insertSitus); // Insert new data
                }

                ContentTags::where('content_id', $insert['id'])->delete(); // Delete data

                foreach ($tags as $val) {
                    $insertTags = [
                        'tag_name' => $val,
                        'content_id' => $insert['id']
                    ];

                    ContentTags::insert($insertTags); // Insert new data
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
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

        if (!empty($data['site_id'])) {
            $kategori = Category::where('site_id', $data['site_id'])->get();
        } else {
            $kategori = Category::whereNull('site_id')->get();
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
