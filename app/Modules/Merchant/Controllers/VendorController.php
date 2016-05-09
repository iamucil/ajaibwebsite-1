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
        $nama       = $vendor->name;
        $result     = $vendor->delete();

        if(request()->ajax()){
            if(true === $result){
                $return     = [
                    'result' => true,
                    'message' => 'Proses penghapusan data '.$nama.' Berhasil',
                    'status' => 201
                ];
            } else {
                $return     = [
                    'result' => true,
                    'message' => 'Error occured',
                    'status' => 500
                ];
            }

            return response()->json($return, (int)$return['status'], [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
        }else{
            flash()->success('Data terhapus');
            return redirect()->route('vendor.category.index');
        }
    }

    public function getDataGrid($category = null)
    {
        $rows       = [];
        $idx        = 0;

        $vendors    = Vendor::has('category')->get();

        foreach ($vendors as $vendor) {
            $id     = (int)$vendor->id;
            $trans  = (int)$vendor->transactions->count();
            $link_detail        = route("vendor.show", $args = ['id' => $id]);
            $url_edit           = route("vendor.edit", $args = ['id' => $vendor->id]);
            $link_edit          = '<i class="fontello-pencil">&nbsp;</i>^'.$url_edit.'^_self';
            if((int)$trans <> 0) {
                $link_delete    = '<i class="fontello-cancel-circled-outline">&nbsp;</i>^javascript:alertify.log("Data kategori sudah memiliki data transaksi, Hapus data transaksi yang berkaitan dengan vendor '.$vendor->name.'.");^_self';
            }else{
                $link_delete    = '<i class="fontello-cancel-circled">&nbsp;</i>^#^_self^javascript:doDelete("'.$vendor->id.'");';
            }

            $rows[$idx]['id']   = $id;
            $rows[$idx]['data'] = [
                $id,
                $vendor->name.'^'.$link_detail.'^_self',
                $vendor->category->name,
                $vendor->description,
                $trans,
                $link_edit,
                $link_delete,
            ];

            $idx+=1;
        }
        return response()->json(compact('rows', 'vendors'), 200, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
    }
}
