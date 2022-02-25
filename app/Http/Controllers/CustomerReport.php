<?php

namespace App\Http\Controllers;
use App\Models\Section;
use App\Models\Payment;

use Illuminate\Http\Request;

class CustomerReport extends Controller
{
    public function index(){
        $sec = Section::all();
        return view('reports.customer_report',compact('sec'));
    }

    public function customers_search(Request $request){

        // فى حالة البحث بعدم تحديد تاريخ

        if($request->Section && $request->product && $request->start_at =='' && $request->end_at ==''){

            $invoices = Payment::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sec = Section::all();
             return view('reports.customer_report',compact('sec'))->withDetails($invoices);




             // فى حالة البحث بتحديد تاريخ

        }else{

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

      $invoices = Payment::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
       $sec = Section::all();
       return view('reports.customer_report',compact('sec'))->withDetails($invoices);

        }

    }
}
