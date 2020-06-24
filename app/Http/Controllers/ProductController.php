<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

class ProductController extends Controller
{
    public function index()
    {
        //BUAT QUERY MENGGUNAKAN MODEL PRODUCT, DENGAN MENGURUTKAN DATA BERDASARKAN CREATED_AT
        //KEMUDIAN LOAD TABLE YANG BERELASI MENGGUNAKAN EAGER LOADING WITH()
        //ADAPUN CATEGORY ADALAH NAMA FUNGSI YANG NNTINYA AKAN DITAMBAHKAN PADA PRODUCT MODEL
        $product = Product::with(['category'])->orderBy('created_at', 'DESC');

        //JIKA TERDAPAT PARAMETER PENCARIAN DI URL ATAU Q PADA URL TIDAK SAMA DENGAN KOSONG
        if (request()->q != '') {
            //MAKA LAKUKAN FILTERING DATA BERDASARKAN NAME DAN VALUENYA SESUAI DENGAN PENCARIAN YANG DILAKUKAN USER
            $product = $product->where('name', 'LIKE', '%' . request()->q . '%');
        }

        // terakhir load 10 data per halamannya
        $product = $product->paginate(10);

        //LOAD VIEW INDEX.BLADE.PHP YANG BERADA DIDALAM FOLDER PRODUCTS
        //DAN PASSING VARIABLE $PRODUCT KE VIEW AGAR DAPAT DIGUNAKAN
        return view('products.index', compact('product'));
    }

    public function create()
    {
        // query untuk mengambil semua data category
        $category = Category::orderBy('name', 'DESC')->get();

        // load view create.blade.php yang berada pada folder products dan parsing data category
        return view('products.create', compact('category'));
    }

    public function store(Request $request)
    {
        // validasi request nya
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id', //category_id kita cek harus ada di table categories dengan field id
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'required|image|mimes:png,jpg,jpeg' //gambar divalidasi harus bertipe png,jpg dan jpeg
        ]);

        // jika file nya ada
        if ($request->hasFile('image')) {
            // simpan file gambar tersebut dalam variable file
            $file = $request->file('image');

            // kemudian nama file kita buat custom dengan perpaduan time dan slug dari nama produk, adapun extensionnya kita gunakan bawaan file tersebut
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();

            // simpan file nya kedalam folder public/products dan parameter kedua adalah nama custom untuk file tersebut
            $file->storeAs('public/products', $filename);

            $product = Product::create([
                'name' => $request->name,
                'slug' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image' => $filename, //PASTIKAN MENGGUNAKAN VARIABLE FILENAM YANG HANYA BERISI NAMA FILE SAJA (STRING)
                'price' => $request->price,
                'weight' => $request->weight,
                'status' => $request->status
            ]);

            // jika sudah maka redirrect ke list produk
            return redirect(route('product.index'))->with(['success' => 'Produk baru ditambahkan']);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id); //QUERY UNTUK MENGAMBIL DATA PRODUK BERDASARKAN ID
        //HAPUS FILE IMAGE DARI STORAGE PATH DIIKUTI DENGNA NAMA IMAGE YANG DIAMBIL DARI DATABASE
        File::delete(storage_path('app/public/products/' . $product->image));
        //KEMUDIAN HAPUS DATA PRODUK DARI DATABASE
        $product->delete();
        //DAN REDIRECT KE HALAMAN LIST PRODUK
        return redirect(route('product.index'))->with(['success' => 'Produk Sudah Dihapus']);
    }

    public function massUploadForm()
    {
        $category = Category::orderBy('name', 'DESC')->get();
        return view('products.bulk', compact('category'));
    }
}
