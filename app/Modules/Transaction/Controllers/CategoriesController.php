<?php namespace App\Modules\Transaction\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Transaction\Models\Category;
use Validator;

/**
* FILENAME     : CategoriesController.php
* @package     : CategoriesController
*/
class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories         = Category::where('type', '=', 'transaction')
            ->orderBy('created_at', 'DESC')
            ->get();
        foreach ($categories as $key => $value) {
            # code...
            $categories[$key]['transaction_count'] = $value->Transactions->count();
        }
        return response()->json($categories,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validate   = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
        ]);

        if($validate->fails()){
            return response()->json(array(
                'status' => 500,
                'message' => $validate->errors()->first()
            ),500);
        }else{
            $category   = new Category;
            $category->name     = $request->name;
            $category->type     = 'transaction';
            $category->description  = $request->description;

            if($category->save()){
                return response()->json(array(
                    'status' => 200,
                    'message' => 'Penyimpanan data berhasil'
                ),200);                
            }else{
                return response()->json(array(
                    'status' => 200,
                    'message' => 'Penyimpanan data gagal'
                ),200);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $category       = Category::findOrFail($id);
        return view('Transaction::Categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $category       = Category::findOrFail($id);

        return response()->json($category,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
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
                    'message' => $validate->errors()->first()
                ),200);
        }else{
            $category->name         = $request->name;
            $category->description  = $request->description;
            if($category->save()){                
                return response()->json(array(
                    'status' => 200,
                    'message' => 'Penyimpanan data berhasil.'
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
     * @return Response
     */
    public function destroy($id)
    {
        $category       = Category::findOrFail($id);
        $count_transaction = $category->Transactions->count();// handle verifycation on backend side
        if($count_transaction > 0){
            return response()->json(array(
                    'status' => 500,
                    'message' => 'Category Has Many Transactions.'
                ),200);
        }else{
            $delete = $category->delete();
            if($delete){
                return response()->json(array(
                    'status' => 200,
                    'message' => 'Data berhasil terhapus.'
                ),200);
            }else{
                return response()->json(array(
                    'status' => 500,
                    'message' => 'Data gagal dihapus.'
                ),200);
            }
        }
    }
}
?>