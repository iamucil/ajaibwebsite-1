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
        $categories     = [];
        // $categories         = Category::where('type', '=', 'transaction')
        //     ->orderBy('created_at', 'DESC')
        //     ->paginate(15);
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
        $nama           = $category->name;
        $result         = $category->delete();

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

            return redirect()->route('transaction.category.index');
        }
    }

    public function getDataGrid()
    {
        $head       = [];
        $rows       = [];
        $idx        = 0;
        $categories = Category::where('type', '=', 'transaction')
            ->orderBy('created_at', 'DESC')
            ->get();
        foreach ($categories as $category) {
            $transactions       = $category->Transactions()->count();
            $url_edit           = route("transaction.category.edit", $args = ['id' => $category->id]);
            $link_edit          = '<i class="fontello-pencil">&nbsp;</i>^'.$url_edit.'^_self';

            if((int)$transactions <> 0) {
                $link_delete    = '<i class="fontello-cancel-circled-outline">&nbsp;</i>^javascript:alertify.log("Data kategori sudah memiliki transaksi, Hapus transaksi yang berkaitan dengan kategori '.$category->name.'.");^_self';
            }else{
                // data bisa di hapus karena tidak mempunyai data transaksi
                $link_delete    = '<i class="fontello-cancel-circled">&nbsp;</i>^javascript:void(0);^_self^javascript:doDelete("'.$category->id.'");';
            }
            $rows[$idx]['id']   = (int)$category->id;
            $rows[$idx]['data'] = [
                (int)$category->id,
                $category->name,
                $category->description ?: '&mdash',
                $transactions,
                $link_edit,
                $link_delete,
            ];
            $idx++;
        }
        return response()->json(compact('rows'), 200, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
    }
}
?>