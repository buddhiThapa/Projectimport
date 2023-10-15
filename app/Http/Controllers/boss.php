<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;
use App\Imports\AmazonImport;
use Maatwebsite\Excel\HeadingRowImport;
use Session;

class boss extends Controller
{
    function Chartsheet(request $request){
       $state = DB::table('amazon_datas')->groupBy('ship_to_state')->pluck('ship_to_state');
       $customer_type = DB::table('amazon_datas')->groupBy('customer_type')->pluck('customer_type');
       $vendor = DB::table('amazon_datas')->groupBy('vendor')->pluck('vendor');
       $payment_mode = DB::table('amazon_datas')->where('payment_mode','!=','')->groupBy('payment_mode')->pluck('payment_mode');
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
            $amazon_data->where('ship_to_state',$state);
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

        if($request->from_date != '' && $request->to_date!=''){
            $amazon_data->where('order_date','>=',$request->from_date)
            ->where('order_date','<=',$request->to_date);
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

        Session::forget('vendor_type');
        Session::put('vendor_type',$request->file_type);
            $file = $request->file('import');
            $column = (new HeadingRowImport)->toArray($file);
            // dump($column);
            // if($request->file_type == 'amazon' ){

                if ($column[0][0][4] == 'order_id'
                && $column[0][0][7] == 'order_date'
                && $column[0][0][9] == 'quantity'
                && $column[0][0][24] == 'ship_to_state'
                && $column[0][0][38] == 'sgst_tax'
                && $column[0][0][75] == 'payment_method_code'
                ){
    
                // $file = $request->file('file');
                    $import = new AmazonImport;
                    $import->import($file);
    
                    if ($import->failures()->isNotEmpty()) {
                        dd($import->failures());
                        return back()->withFailures($import->failures());
                    }
                    if(!empty(Session::get('error_srTar'))){
                        return redirect()->back()->with('error', 'Error occured please check.');
                    }
                    return back()->withStatus('data imported successfully.');
    
                }else{
                    return redirect()->back()->with('error', 'Invalid template.');
                }
            // }
    //    dd($request->all());
    }

    function credit_note(){
        $state = DB::table('amazon_datas')->groupBy('ship_to_state')->pluck('ship_to_state');
        $customer_type = DB::table('amazon_datas')->groupBy('customer_type')->pluck('customer_type');
        $vendor = DB::table('amazon_datas')->groupBy('vendor')->pluck('vendor');
        $payment_mode = DB::table('amazon_datas')->where('payment_mode','!=','')->groupBy('payment_mode')->pluck('payment_mode');
        $gst_percentage = DB::table('amazon_datas')->groupBy('gst_percentage')->pluck('gst_percentage');
        $state = collect($state)->toArray();
        $customer_type = collect($customer_type)->toArray();
        $vendor = collect($vendor)->toArray();
        $payment_mode = collect($payment_mode)->toArray();
        $gst_percentage = collect($gst_percentage)->toArray();
        return view('credit_note',compact('state','gst_percentage','payment_mode','vendor','customer_type'));
        
    }

    function dedit_note(){
        $state = DB::table('amazon_datas')->groupBy('ship_to_state')->pluck('ship_to_state');
        $customer_type = DB::table('amazon_datas')->groupBy('customer_type')->pluck('customer_type');
        $vendor = DB::table('amazon_datas')->groupBy('vendor')->pluck('vendor');
        $payment_mode = DB::table('amazon_datas')->where('payment_mode','!=','')->groupBy('payment_mode')->pluck('payment_mode');
        $gst_percentage = DB::table('amazon_datas')->groupBy('gst_percentage')->pluck('gst_percentage');
        $state = collect($state)->toArray();
        $customer_type = collect($customer_type)->toArray();
        $vendor = collect($vendor)->toArray();
        $payment_mode = collect($payment_mode)->toArray();
        $gst_percentage = collect($gst_percentage)->toArray();
        return view('dedit_note',compact('state','gst_percentage','payment_mode','vendor','customer_type'));
        
    }
}
