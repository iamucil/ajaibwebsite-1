<?php

namespace App\Modules\Merchant\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Merchant\Models\VendorCategory as Category;
use Validator;
class VendorCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories     = Category::where('type', '=', 'vendor')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);
        return view('Merchant::Categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Merchant::Categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate   = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
        ]);

        if($validate->fails()){
            flash()->error($validate->errors()->first());

            return redirect()->route('vendor.category.create')->withInput($request->except(['_token']))->withErrors($validate);
        }else{
            $category   = new Category;
            $category->name     = $request->name;
            $category->type     = 'vendor';
            $category->description  = $request->description;

            if($category->save()){
                flash()->success('Penyimpanan data berhasil');
                return redirect()->route('vendor.category.index');
            }else{
                flash()->warning('Penyimpanan data gagal');
                return redirect()->route('vendor.category.create');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category       = Category::findOrFail($id);
        return view('Merchant::Categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category       = Category::findOrFail($id);

        return view('Merchant::Categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$request->isMethod('put')){
            app::abort('403', 'unauthorized');
        }

        $category       = Category::find($id);
        $validate       = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,'.$category->id.',id',
        ]);

        if($validate->fails()){
            flash()->error($validate->errors()->first());
            return redirect()->route('vendor.category.edit', $id)->withInput($request->except(['_token']))->withErrors($validate);
        }else{
            $category->name         = $request->name;
            $category->description  = $request->description;
            if($category->save()){
                flash()->success('Penyimpanan data berhasil');
                return redirect()->route('vendor.category.index');
            }else{
                flash()->warning('Penyimpanan data gagal');
                return redirect()->route('vendor.category.edit', $id);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category       = Category::findOrFail($id);
        $category->delete();

        flash()->success('Data terhapus');

        return redirect()->route('vendor.category.index');
    }
}
