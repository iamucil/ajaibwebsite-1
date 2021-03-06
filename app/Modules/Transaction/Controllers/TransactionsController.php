<?php namespace App\Modules\Transaction\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Modules\Transaction\Models\Transaction;
use App\Modules\Transaction\Models\Category;
use App\Modules\Transaction\Models\TransactionDetail;
use App\Modules\Merchant\Models\Vendor;
use Validator;
use DB;
use Crypt;

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
    public function create(Request $request)
    {
        return view('Transaction::create', compact('categories', 'satuan_qty', 'transactions', 'vendors'));
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
            $transaction->vendor_id     = $request->vendor_id ?: null;

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
        $data       = Transaction::findOrFail($id);
        return view('Transaction::show', compact('data'));
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

    public function getDataGrid()
    {
        $head       = [];
        $rows       = [];
        $idx        = 0;
        $assignee   = auth()->user();
        $transactions   = Transaction::with('Category')
            ->has('TransactionDetails')
            ->whereHas('Assigne', function ($query) use ($assignee) {
                if($assignee->hasRole(['admin', 'root'])) {
                    // return $query->where('1','=','1');
                } else{
                    return $query->where('id', '=', $assignee->id);
                }
            })
            ->has('AccountPayable')
            ->orderBy('tanggal', 'DESC')
            ->orderBy('category_id', 'ASC')
            ->get();
        if(false === $transactions->isEmpty()) {
            foreach ($transactions as $transaction) {
                $url_detail             = route("transactions.show", $args = ['id' => $transaction->id]);
                $url_kategori_detail    = route("transaction.category.show", $args = ['id' => $transaction->Category->id]);
                $url_export_pdf         = route('transactions.invoice.print', [\Crypt::encrypt($transaction->id), 'pdf']);
                $url_print_html         = route('transactions.invoice.print', \Crypt::encrypt($transaction->id));
                $url_print_image        = route('transactions.invoice.print', [\Crypt::encrypt($transaction->id),'image']);
                $details                = $transaction->TransactionDetails;
                $account_payable        = $transaction->AccountPayable;
                $signer                 = $transaction->Assigne;
                $rows[$idx]['id']       = (int)$transaction->id;
                $rows[$idx]['data']     = [
                    $transaction->invoice_number.'^'.$url_detail.'^_self', // use this field to show detail transaction
                    date('Y-m-d', strtotime($transaction->tanggal)),
                    $transaction->Category->name.'^'.$url_kategori_detail.'^_self', // use this field to show all transaction in category
                    $signer->firstname ?: $signer->name,
                    $account_payable->phone_number,
                    $account_payable->email,
                    $transaction->keterangan,
                    // null,   // action edit
                    // null,   // action delete
                    '<i class="glyphicon glyphicon-duplicate">^'.$url_print_html,   // print html
                    '<i class="glyphicon glyphicon-credit-card" alt="invoice"></i>^'.$url_export_pdf,   // print pdf
                    '<i class="glyphicon glyphicon-save-file"></i>^'.$url_print_image,   // export image
                ];

                $idx+=1;
            }
        }
        return response()->json(compact('rows'), 200, [], JSON_PRETTY_PRINT)->header('Content-Type', 'application/json');
    }
}
