<?php

namespace App\Http\Controllers;
use App\Models\Payment;

use Illuminate\Http\Request;

class InovicesReport extends Controller
{
    public function index(){
        return view('reports.invoice_report');
    }

    public function report_search(request $request){

        $rdio = $request->rdio;

        // البحث بنوع الفاتورة

        if($rdio == 1){

            // فى حالة عدم تحديد تاريخ

            if($request->type && $request->start_at =='' && $request->end_at ==''){

                $invoices = Payment::select('*')->where('status','=',$request->type)->get();
                $type = $request->type;
                return view('reports.invoice_report',compact('type'))->withDetails($invoices);



                // فى حالة تحديد تاريخ

            }else{

                $start_at = date($request->start_at);
                $end_at   = date($request->end_at);
                $type     = $request->type;

                $invoices = Payment::whereBetween('invoice_Date',[$start_at,$end_at])->where('status','=',$request->type)->get();
                return view('reports.invoice_report',compact('type','start_at','end_at'))->withDetails($invoices);

            }


//*********************************************************************************** */

        // البحث برقم الفاتورة

        }else{

            $invoices = Payment::select('*')->where('invoice_number','=',$request->invoice_number)->get();
            return view('reports.invoice_report')->withDetails($invoices);

        }

    }
}
