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
            ->paginate(15);
        // $categories         = [];
        return view("Transaction::Categories.index", compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Transaction::Categories.create');
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
            flash()->error($validate->errors()->first());

            return redirect()->route('transaction.category.create')->withInput($request->except(['_token']))->withErrors($validate);
        }else{
            $category   = new Category;
            $category->name     = $request->name;
            $category->type     = 'transaction';
            $category->description  = $request->description;

            if($category->save()){
                flash()->success('Penyimpanan data berhasil');
                return redirect()->route('transaction.category.index');
            }else{
                flash()->warning('Penyimpanan data gagal');
                return redirect()->route('transaction.category.create');
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

        return view('Transaction::Categories.edit', compact('category'));
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
            app::abort('403', 'unauthorized');
        }

        $category       = Category::find($id);
        $validate       = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,'.$category->id.',id',
        ]);

        if($validate->fails()){
            flash()->error($validate->errors()->first());
            return redirect()->route('transaction.category.edit', $id)->withInput($request->except(['_token']))->withErrors($validate);
        }else{
            $category->name         = $request->name;
            $category->description  = $request->description;
            if($category->save()){
                flash()->success('Penyimpanan data berhasil');
                return redirect()->route('transaction.category.index');
            }else{
                flash()->warning('Penyimpanan data gagal');
                return redirect()->route('transaction.category.edit', $id);
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
        $category->delete();

        flash()->success('Data terhapus');

        return redirect()->route('transaction.category.index');
    }
}
?>