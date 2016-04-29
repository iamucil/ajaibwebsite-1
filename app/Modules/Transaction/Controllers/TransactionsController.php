<?php namespace App\Modules\Transaction\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Models\TransactionDetail;
use Validator;
use DB;
use Crypt;
use Auth;
class TransactionsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $transactions   = Transaction::orderBy('created_at', 'DESC')->get();
        foreach ($transactions as $key => $value) {
            # code...
            $transactions[$key]['enc_id'] = Crypt::encrypt($value['id']);
        }
        return response()->json($transactions,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $satuan_qty     = DB::table('quantities')->orderBy('name', 'ASC')->get();
        $categories     = Category::where('type', '=', 'transaction')->orderBy('name', 'ASC')->lists('name', 'id');
        $form = array();
        $form['auth_user_name'] = Auth::user()->name;
        return response()->json(['category' => $categories , 'satuan' => $satuan_qty, 'form' => $form] ,200);
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
        // dd($request->tanggal);
        // $check          = date_parse_from_format('m/d/YYYY', $request->tanggal);
        // $tanggal        = $request->tanggal;
        // dd(compact('tanggal', 'check'));
        $transactions = $request->transactions;
        if($transactions AND is_array($transactions)) {
            foreach ($transactions['quantity'] as $key => $qty) {
                $quantity+=$qty;
                $amount+=$transactions['amount'][$key];
                $details[$index]    = new TransactionDetail([
                    'quantity' => $qty,
                    'quantity_id' => $transactions['satuan'][$key],
                    'amount' => $transactions['amount'][$key],
                    'keterangan' => $transactions['keterangan'][$key],
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
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required',
            'amount' => 'required',
            'transactions' => 'required',
        ], [
            'user_id.required' => 'Pastikan Account Payable exists di dalam sistem. Gunakan Auto Complete dari form untuk membantu. ex: 85640427774',
            'user_id.exists' => 'Pastikan Account Payable exists di dalam sistem. Gunakan Auto Complete dari form untuk membantu. ex: 85640427774'
        ]);

        if($validate->fails()){
            return response()->json(array(
                'status' => 500,
                'message' => $validate->errors()->first()
            ),500);
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
     * @return Response
     */
    public function show($id)
    {
        $data       = Transaction::findOrFail($id);
        $data['phone_number'] = $data->AccountPayable->phone_number;
        $data['email'] = $data->AccountPayable->email;
        $data['category_name'] = $data->Category->name;
        $detail = $data->TransactionDetails;
        return response()->json(['transaction'=>$data,'detail_transaction'=>$detail],200);
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

    public function printInvoice($id, $print = 'html')
    {
        $id                 = Crypt::decrypt($id);
        $transaction        = Transaction::findOrFail($id);

        switch (strtoupper($print)) {
            case 'PDF':
                $pdf    = app()->make('snappy.pdf.wrapper');
                $pdf->loadView('Transaction::print', compact('transaction'));
                $pdf->setPaper('A4');
                // $pdf->setOrientation('landscape');
                return $pdf->inline('invoice_'. $transaction->invoice_number .'.pdf');
                break;
            case 'IMAGE':
                $img    = app()->make('snappy.image.wrapper');
                $img->loadView('Transaction::print', compact('transaction'));
                return $img->download('invoice_'. $transaction->invoice_number .'.jpg');
                break;
            case 'HTML':
                return view('Transaction::print', compact('transaction'));
                break;
            default:
                return view('Transaction::print', compact('transaction'));
                # code...
                break;
        }
    }
}
