<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;

use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class AmazonImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // dd($collection);
        $fail = [];
        $vendor = Session::get('vendor_type');
        // dd($vendor);

        foreach ($collection as $key => $value) {
            $insert = DB::table('amazon_datas')->insert(
                [
                    'order_id' => $value['order_id'],
                    'order_date' => @date('Y-m-d',strtotime($value['order_date'])),
                    'ship_to_state' => $value['ship_to_state'],
                    'total_sale' => $value['principal_amount'],
                    'gst_percentage' => $value['sgst_tax'],
                    'payment_mode' => $value['payment_method_code'],
                    'vendor' => $vendor,
                    'customer_type' => @$value['customer_type'],
                    'credit_note' => $value['credit_note_no'],
                    'debit_note' => $value['debit_note'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            );

            if(!$insert){
                $fail[] = [
                    'order_id' => $value['order_id'],
                    'order_date' => $value['order_date'],
                    'ship_to_state' => $value['ship_to_state'],
                    'gst_percentage' => $value['sgst_tax'],
                    'payment_mode' => $value['payment_method_code'],
                    'total_sale' => $value['principal_amount'],
                    'credit_note' => $value['credit_note_no'],
                    'debit_note' => $value['debit_note']
                ];
            }
            // return redirect()->to()->with('success','Data Imported successfully');

        }     
        
    }

    public function rules(): array
    {
        return [
            // '*.year' => 'required|after:'.(date('Y')-1).'|before:'.(date('Y')+1).'|date_format:Y',
            // '*.month' => 'required',
            // '*.sr_user_code' => 'required',
            // '*.month_target' => 'required|numeric|min:0|not_in:0',
        ];
    }
}
