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
            // ->paginate(15)
            ->get();
        foreach ($vendors as $key => $value) {
            # code...
            $value['category_name'] = $value->category->name;
        }
        return response()->json($vendors,200);
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
        return response()->json(['categories' => $categories],200);
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
            return response()->json(array(
                'status' => 500,
                'message' => $validate->errors()->first()
            ),500);
        }else{
            $vendor->category_id            = $request->category_id;
            $vendor->name                   = $request->name;
            $vendor->description            = $request->description;

            if($vendor->save()){
                    return response()->json(array(
                    'status' => 200,
                    'message' => 'Penyimpanan data berhasil'
                ),200);
            }else{                
                return response()->json(array(
                    'status' => 500,
                    'message' => 'Penyimpanan data gagal'
                ),200);
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
        $vendor['category_name'] = $vendor->category->name;
        return response()->json($vendor,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories     = Category::where('type', '=', 'vendor')
            ->orderBy('name', 'ASC')->lists('name', 'id');
        $vendor         = Vendor::findOrFail($id);
        $vendor['category_id'] = (string) $vendor['category_id'];
        return response()->json(['vendors' => $vendor,'categories' => $categories] ,200);
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
                return response()->json(array(
                    'status' => 403,
                    'message' => 'Unauthorized action.'
                ),403);
        }

        $vendor         = Vendor::findOrFail($id);
        $validate       = Validator::make($request->all(), [
            'name' => 'required|unique:vendors,name,'.$vendor->id.',id',
            'category_id' => 'required|exists:categories,id',
        ]);

        if($validate->fails()){            

            return response()->json(array(
                'status' => 500,
                'message' => $validate->errors()->first()
            ),200);
        }else{
            $vendor->category_id            = $request->category_id;
            $vendor->name                   = $request->name;
            $vendor->description            = $request->description;

            if($vendor->save()){                
                return response()->json(array(
                    'status' => 200,
                    'message' => 'Penyimpanan data berhasil'
                ),200);
            }else{                
                return response()->json(array(
                    'status' => 500,
                    'message' => 'Penyimpanan data gagal'
                ),200);
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
        $delete = $vendor->delete();
        if($delete)
            return response()->json(array(
                    'status' => 200,
                    'message' => 'Data berhasil dihapus.'
                ),200);
        else
            return response()->json(array(
                    'status' => 500,
                    'message' => 'Data gagal dihapus.'
                ),200);        
    }
}
