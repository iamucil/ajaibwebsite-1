<?php

namespace App\Modules\Merchant\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Merchant\Models\Vendor;
use App\Modules\Merchant\Models\VendorCategory as Category;
use Validator;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $methods        = [
        'POST' => 'POST',
        'GET' => 'GET',
        'PUT' => 'PUT',
        'DELETE' => 'DELETE'
    ];
    public function index()
    {
        $vendors    = Vendor::orderBy('category_id', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);
        return view('Merchant::index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories     = Category::where('type', '=', 'vendor')
            ->orderBy('name', 'ASC')->lists('name', 'id');
        $methods        = $this->methods;
        // dd($categories);
        return view('Merchant::create', compact('categories', 'methods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendor         = new Vendor;
        $validate       = Validator::make($request->all(), [
            'name' => 'required|unique:vendors,name',
            'category_id' => 'required|exists:categories,id',
        ]);

        if($validate->fails()){
            flash()->error($validate->errors()->first());

            return redirect()->route('vendor.create')
                ->withInput($request->except(['_token']))
                ->withErrors($validate);
        }else{
            $vendor->category_id            = $request->category_id;
            $vendor->name                   = $request->name;
            $vendor->description            = $request->description;

            if($vendor->save()){
                flash()->success('Penyimpanan data berhasil');
                return redirect()->route('vendor.index');
            }else{
                flash()->error('Penyimpanan data gagal');
                return redirect()->route('vendor.create')
                    ->withInput($request->except(['_token']));
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
        $vendor     = Vendor::findOrFail($id);
        return view('Merchant::show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendor         = Vendor::findOrFail($id);
        $categories     = Category::where('type', '=', 'vendor')
            ->orderBy('name', 'ASC')->lists('name', 'id');
        $methods        = $this->methods;
        return view('Merchant::edit', compact('categories', 'methods', 'vendor'));
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

        $vendor         = Vendor::findOrFail($id);
        $validate       = Validator::make($request->all(), [
            'name' => 'required|unique:vendors,name,'.$vendor->id.',id',
            'category_id' => 'required|exists:categories,id',
        ]);

        if($validate->fails()){
            flash()->error($validate->errors()->first());

            return redirect()->route('vendor.edit', $vendor->id)
                ->withInput($request->except(['_token']))
                ->withErrors($validate);
        }else{
            $vendor->category_id            = $request->category_id;
            $vendor->name                   = $request->name;
            $vendor->description            = $request->description;

            if($vendor->save()){
                flash()->success('Penyimpanan data berhasil');
                return redirect()->route('vendor.index');
            }else{
                flash()->error('Penyimpanan data gagal');
                return redirect()->route('vendor.edit', $vendor->id)
                    ->withInput($request->except(['_token']));
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
        $vendor     = Vendor::findOrFail($id);
        $vendor->delete();

        flash()->success('Data terhapus');

        return redirect()->route('vendor.index');
    }
}
