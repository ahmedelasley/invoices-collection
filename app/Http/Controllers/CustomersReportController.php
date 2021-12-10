<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sections;
use App\invoices;

class CustomersReportController extends Controller
{
    //
    public function index(){
        $sections = sections::all();
        return view('reports.customers_report',compact('sections'));
    }
  
  
    public function Search_customers(Request $request){
   
        if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') {
            // في حالة البحث بدون التاريخ
            $invoices = invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = sections::all();
            return view('reports.customers_report',compact('sections'))->withDetails($invoices);
  
      
       } else {
            // في حالة البحث بتاريخ

            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
            $sections = sections::all();
            return view('reports.customers_report',compact('sections'))->withDetails($invoices);
        }

    }
}
