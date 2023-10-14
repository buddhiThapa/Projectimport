<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;
use App\Import\AmazonImport;
use Maatwebsite\Excel\HeadingRowImport;
use Session;

class boss extends Controller
{
    function Chartsheet(request $request){
       $state = DB::table('amazon_datas')->groupBy('bill_from_state')->pluck('bill_from_state');
       $customer_type = DB::table('amazon_datas')->groupBy('customer_type')->pluck('customer_type');
       $vendor = DB::table('amazon_datas')->groupBy('vendor')->pluck('vendor');
       $payment_mode = DB::table('amazon_datas')->groupBy('payment_mode')->pluck('payment_mode');
       $gst_percentage = DB::table('amazon_datas')->groupBy('gst_percentage')->pluck('gst_percentage');
        $state = collect($state)->toArray();
        $customer_type = collect($customer_type)->toArray();
        $vendor = collect($vendor)->toArray();
        $payment_mode = collect($payment_mode)->toArray();
        $gst_percentage = collect($gst_percentage)->toArray();
        return view('blank',compact('state','gst_percentage','payment_mode','vendor','customer_type'));
        
    }

    function getAmazonData(request $request){
        $state = $request->state;
        // dd($state);
        $amazon_data = DB::table('amazon_datas as ad');
        if($state !=''){
            $amazon_data->where('bill_from_state',$state);
        }
        if($request->vendor !=''){
            $amazon_data->where('vendor',$request->vendor);
        }
        if($request->payment_mode !=''){
            $amazon_data->where('payment_mode',$request->payment_mode);
        }
        if($request->gst_percentage !=''){
            $amazon_data->where('gst_percentage',$request->gst_percentage);
        }

        $amazon_data = $amazon_data->get()->toArray();
        $data = collect($amazon_data);
        return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    function importView(request $request){
        return view('import');
    }


    function import(request $request){
        $request->validate([
            'file_type'=>'required',
            'import'=>'required|mimes:xlsx,xls,csv',
        ]);

        Session::forget('error_srTar');
            $file = $request->file('import');
            $column = (new HeadingRowImport)->toArray($file);
            dump($column);
            if($request->file_type == 'amazon' ){

                if ($column[0][0][4] == 'order_id'
                && $column[0][0][7] == 'order_date'
                && $column[0][0][9] == 'quantity'
                && $column[0][0][24] == 'ship_to_state'
                && $column[0][0][38] == 'sgst_tax'
                && $column[0][0][75] == 'payment_method_code'
                ){
    
                // $file = $request->file('file');
                //     $import = new SrTargetImport;
                //     $import->import($file);
    
                //     if ($import->failures()->isNotEmpty()) {
                //         return back()->withFailures($import->failures());
                //     }
                //     if(!empty(Session::get('error_srTar'))){
                //         return redirect()->back()->with('error', 'Error occured please check.');
                //     }
                    return back()->withStatus('data imported successfully.');
    
                }else{
                    return redirect()->back()->with('error', 'Invalid template.');
                }
            }
       dd($request->all());
    }
}