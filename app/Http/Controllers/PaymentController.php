<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;

use App\Models\Payment;
use App\Models\Section;
use App\Models\invoice_detail;
use App\Models\Attachment;
use App\models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\AddInovice;
use App\Exports\PaymentExport;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment = Payment::all();
        return view('invoices.invoice',compact('payment'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $section = Section::all();
        return view('invoices.add_invoice',compact('section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Payment::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_comission' => $request->Amount_comission,
            'Discount' => $request->Discount,
            'Value_Vat' => $request->Value_Vat,
            'Rate_Vat' => $request->Rate_Vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            "note"=>$request->note,
        ]);
        $payment_id = Payment::latest()->first()->id;

        invoice_detail::create([
            'id_invoice' => $payment_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->Section,
            'status' => 'غير مدفوعة',
            'value_status' =>2,
            'note' => $request->section,
            'user' =>(Auth::user()->name),
        ]);
        if ($request->hasFile('pic')) {

            $payment_id = Payment::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Attachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $payment_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


           // $user = User::first();


            $user = User::get();

            $Payment = Payment::latest()->first();

            //$user->notify(new \App\Notifications\AddInovice($Payment));
            Notification::send($user, new \App\Notifications\AddInovice($Payment));


        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pay_show = Payment::where('id', $id)->first();
        return view('invoices.status_update',compact('pay_show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    $payment_ed = Payment::where('id',$id)->first();
    $section    = Section::all();
    return view('invoices.edit_invoice',compact('payment_ed','section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $payment = Payment::findOrFail($request->invoice_id);
        $payment->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_comission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_Vat,
            'Rate_VAT' => $request->Rate_Vat,
            'Total' => $request->total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $pay_id = Payment::where('id', $id)->first();
        $attachment = Attachment::where('invoice_id', $id)->first();

        $id_page=$request->id_page;

        if(!$id_page==2){

        if (!empty($attachment->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($attachment->invoice_number);
        }

        $pay_id->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/payment');

    }else{

        $pay_id->delete();
        session()->flash('archive_invoice');
        return redirect('/invoice_archive');
    }


    }
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }

    public function status_update($id, Request $request)
    {
        $invoices = Payment::findOrFail($id);



        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->Status,
                'Paymnt_Date' => $request->Payment_Date,
            ]);

            invoice_detail::create([
                'id_invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'Paymnt_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->Status,
                'Paymnt_Date' => $request->Payment_Date,
            ]);
            invoice_detail::create([
                'id_invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 3,
                'note' => $request->note,
                'Paymnt_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/payment');

    }
    public function invoice_paid(){
        $paid = Payment::where('value_status',1)->get();
        return view('invoices.invoice_paid',compact('paid'));
    }
    public function invoice_unpaid(){
        $unpaid = Payment::where('value_status',2)->get();
        return view('invoices.invoice_unpaid',compact('unpaid'));
    }
    public function invoice_partial(){
        $partial = Payment::where('value_status',3)->get();
        return view('invoices.invoice_partial',compact('partial'));
    }

    public function Print_invoice($id)
    {
        $print = Payment::where('id', $id)->first();
        return view('invoices.Print_invoice',compact('print'));
    }

    public function export()
    {
        return Excel::download(new PaymentExport, 'قائمة الفواتير .xlsx');

    }

    public function MarkAsRead_all (Request $request)
    {

        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }
    }
}
