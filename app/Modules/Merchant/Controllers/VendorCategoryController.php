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
            // ->paginate(15)
            ->get();
        foreach ($categories as $key => $value) {
            # code...            
            $count = $value->vendors()->count();            
            
            $value['vendors'] = $count;
        }        
        return response()->json($categories,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            return response()->json(array(
                'status' => 500,
                'message' => $validator->errors()->first()
            ),500);
        }else{

            $category   = new Category;
            $category->name     = $request->name;
            $category->type     = 'vendor';
            $category->description  = $request->description;

            if($category->save()){
                
                return response()->json(array(
                    'status' => 200,
                    'message' => 'Penyimpanan data berhasil'
                ),200);
            }else{                
                return response()->json(array(
                    'status' => 500,
                    'message' => 'Penyimpanan data gagal'
                ),500);
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
        return response()->json(['category' => $category, 'vendors' => $category->vendors],200);
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

        return response()->json($category,200);
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

        $category       = Category::find($id);
        $validate       = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,'.$category->id.',id',
        ]);

        if($validate->fails()){
            return response()->json(array(
                'status' => 500,
                'message' => $validator->errors()->first()
            ),500);
        }else{
            $category->name         = $request->name;
            $category->description  = $request->description;
            if($category->save()){                
                return response()->json(array(
                    'status' => 200,
                    'message' => 'Penyimpanan data berhasil'
                ),200);
            }else{
                return response()->json(array(
                    'status' => 500,
                    'message' => 'Penyimpanan data gagal.'
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
        $category       = Category::findOrFail($id);
        $delete = $category->delete();
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
