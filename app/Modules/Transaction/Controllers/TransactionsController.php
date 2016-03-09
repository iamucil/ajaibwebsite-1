<?php namespace App\Modules\Transaction\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use Validator;
use DB;

class TransactionsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $transactions   = Transaction::orderBy('created_at', 'DESC')
            ->paginate(10);
        return view("Transaction::index", compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $satuan_qty     = DB::table('quantities')
            ->orderBy('name', 'ASC')
            ->get();
            // ->lists('name', 'id');
            // dd($satuan_qty);
        // $satuan         = response()->json($satuan_qty);
        // dd($satuan->getData());
        // dd($satuan_qty);
        $satuan_qty     = response()->json($satuan_qty);
        // dd($satuan_qty->content());
        $categories     = Category::where('type', '=', 'transaction')
            ->orderBy('name', 'ASC')->lists('name', 'id');
            // dd($satuan_qty);
        return view('Transaction::create', compact('categories', 'satuan_qty'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $transaction    = new Transaction;
        $validate       = Validator::make($request->all(), [
            'tanggal' => 'required',
            'category_id' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
        ]);

        if($validate->fails()){
            flash()->error($validate->errors()->first());

            return redirect()->route('transactions.create')
                ->withInput($request->except(['_token']))
                ->withErrors($validate);
        }else{
            $transaction->category_id   = $request->category_id;
            $transaction->tanggal       = date('Y-m-d', strtotime($request->tanggal));
            $transaction->quantity      = str_replace(',', '', $request->quantity);
            $transaction->amount        = str_replace(',', '', $request->amount);
            $transaction->keterangan    = $request->keterangan;

            if($transaction->save()){
                flash()->success('Penyimpanan data berhasil');
                return redirect()->route('transactions.index');
            }else{
                flash()->error('Penyimpanan data gagal');
                return redirect()->route('transactions.create')
                    ->withInput($request->except(['_token']));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
