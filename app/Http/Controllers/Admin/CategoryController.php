<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = Category::query();

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                    type="button" id="action' . $item->id . '"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' . $item->id . '">
                                    <a class="dropdown-item" href="' . route('category.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('category.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>';
                })
                ->editColumn('photo', function ($item) {
                    return $item->photo ? '<img src="' . Storage::url($item->photo) . '" style="max-height: 40px;"/>' : '';
                })
                ->rawColumns(['action', 'photo'])
                ->make();
        }

        return view('pages.admin.category.index');
    }

    public function create()
    {
        return view('pages.admin.category.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $data = $request->all();

            $data['slug'] = Str::slug($request->name);
            $data['photo'] = $request->file('photo')->store('assets/category', 'public');

            Category::create($data);

            return redirect()->route('category.index')->withSuccess('Berhasil membuat  kategori baru!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data category gagal ditambahkan');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $item = Category::findOrFail($id);

        return view('pages.admin.category.edit', [
            'item' => $item,
        ]);
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $data = $request->all();

            $data['slug'] = Str::slug($request->name);
            $data['photo'] = $request->file('photo')->store('assets/category', 'public');

            $item = Category::findOrFail($id);

            $item->update($data);

            return redirect()->route('category.index')->withSuccess('Kategori berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi Kesalahan !');
        }
    }

    public function destroy($id)
    {
        $item = Category::findorFail($id);
        $item->delete();

        return redirect()->route('category.index');

    }
}
