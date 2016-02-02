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
        $vendors    = Vendor::orderBy('vendor_category_id', 'ASC')
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
        $categories     = Category::orderBy('name', 'ASC')->lists('name', 'id');
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
            'vendor_category_id' => 'required|exists:vendor_categories,id',
            'key' => 'required_with:api',
            'params' => 'required_with_all:api,key',
            'method' => 'required_with_all:api,key,params|in:POST,PUT,GET,DELETE',
        ]);

        if($validate->fails()){
            flash()->error($validate->errors()->first());

            return redirect()->route('vendor.create')
                ->withInput($request->except(['_token']))
                ->withErrors($validate);
        }else{
            $vendor->vendor_category_id     = $request->vendor_category_id;
            $vendor->name                   = $request->name;
            $vendor->description            = $request->description;
            $vendor->api                    = $request->api;
            $vendor->key                    = $request->key;
            $vendor->params                 = $request->params;
            $vendor->method                 = $request->method;

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
        //
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
        $categories     = Category::orderBy('name', 'ASC')->lists('name', 'id');
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
            'vendor_category_id' => 'required|exists:vendor_categories,id',
            'key' => 'required_with:api',
            'params' => 'required_with_all:api,key',
            'method' => 'required_with_all:api,key,params|in:POST,PUT,GET,DELETE',
        ]);

        if($validate->fails()){
            flash()->error($validate->errors()->first());

            return redirect()->route('vendor.edit', $vendor->id)
                ->withInput($request->except(['_token']))
                ->withErrors($validate);
        }else{
            $vendor->vendor_category_id     = $request->vendor_category_id;
            $vendor->name                   = $request->name;
            $vendor->description            = $request->description;
            $vendor->api                    = $request->api;
            $vendor->key                    = $request->key;
            $vendor->params                 = $request->params;
            $vendor->method                 = $request->method;

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
