<?php namespace App\Modules\Transaction\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Models\TransactionDetail;
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
            ->paginate(3);
        return view("Transaction::index", compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $satuan_qty     = DB::table('quantities')
            ->orderBy('name', 'ASC')
            ->get();
        $transactions   = response()->json($request->old('transactions', []));
        $satuan_qty     = response()->json($satuan_qty);

        $categories     = Category::where('type', '=', 'transaction')
            ->orderBy('name', 'ASC')->lists('name', 'id');
            // dd($satuan_qty);
        return view('Transaction::create', compact('categories', 'satuan_qty', 'transactions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        /*
        field :
            tanggal
            category_id
            quantity
            amount
            keterangan
            status
            created_at
            updated_at
            number
            customer_id
            operator_id
        */
        $quantity       = 0;
        $amount         = 0;
        $index          = 0;
        $details        = [];

        if($request->transactions AND is_array($request->transactions)) {
            foreach ($request->transactions as $trans) {
                $quantity+=$trans['quantity'];
                $amount+=$trans['amount'];
                $details[$index]    = new TransactionDetail([
                    'quantity' => $trans['quantity'],
                    'quantity_id' => $trans['satuan'],
                    'amount' => $trans['amount'],
                    'keterangan' => $trans['keterangan'],
                    'item' => 'detail-#'.$index,
                ]);
                $index++;
            }
        }

        $request->merge([
            'invoice_number' => rand(100000,999999),
            'quantity' => $quantity,
            'amount' => $amount,
        ]);

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
            $transaction->customer_id   = $request->user_id;
            $transaction->operator_id   = auth()->user()->id;
            $transaction->invoice_number    = $request->invoice_number;
            $transaction->number        = $request->invoice_number;

            if($transaction->save()){
                $transaction->TransactionDetails()->saveMany($details);
                flash()->success('Penyimpanan data berhasil');
                return redirect()->route('transactions.index')
                    ->withInput($request->except(['_token']));
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
