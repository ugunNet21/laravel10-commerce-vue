<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Product;
use App\Category;
use App\User;

use App\Http\Requests\Admin\ProductRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = Product::with(['user','category']);

            return Datatables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                    type="button" id="action' .  $item->id . '"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Aksi
                                </button>
                                <div class="dropdown-menu" aria-labelledby="action' .  $item->id . '">
                                    <a class="dropdown-item" href="' . route('product.edit', $item->id) . '">
                                        Sunting
                                    </a>
                                    <form action="' . route('product.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button type="submit" class="dropdown-item text-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.admin.product.index');
    }


    public function create()
    {
        $users = User::all();
        $categories = Category::all();

        return view('pages.admin.product.create',[
            'users' => $users,
            'categories' => $categories
        ]);
    }


    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        Product::create($data);

        return redirect()->route('product.index')->withSuccess('Produk berhasil ditambahkan');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $item = Product::with(['category','user'])->findOrFail($id);
        $users = User::all();
        $categories = Category::all();

        return view('pages.admin.product.edit',[
            'item' => $item,
            'users' => $users,
            'categories' => $categories
        ]);
    }


    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);

        $data['slug'] = Str::slug($request->name);

        $item->update($data);

        return redirect()->route('product.index')->withSuccess('Produk berhasil diubah');
    }


    public function destroy($id)
    {
        $item = Product::findorFail($id);
        $item->delete();

        return redirect()->route('product.index')->withSuccess('Produk berhasil dihapus');

    }
}
