<?php

namespace App\Services;

use App\Models\invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceStatus;
use Illuminate\Support\Carbon;
use App\Models\Customers;
use App\Models\Addresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoiceExport;

class InvoiceService
{

     public function store($data, $userId)
    {
       
        $totalAmount = 0;

        foreach ($data['items'] as $item) {
            $netAmount = $item['quantity'] * $item['unit_price'];
            $gstPercent = $item['gst_percent'] ?? 0;
            $gstAmount = $netAmount * $gstPercent / 100;
            $total = $netAmount + $gstAmount;
            $totalAmount += $total;
        }
        //invoice table data
        $invoice =  invoice::create([
            'invoice_no' => $this->generateInvoiceNumber($data['invoice_date']??now()),
            'invoice_date' => $data['invoice_date'] ?? now(),
            'customer_id' => $data['customer_id'],
            'invoice_due_date' => $data['invoice_due_date'] ?? null,
            'total_amount'=> $totalAmount,
            'additional_text' => $data['additional_text'] ?? null,
            'created_by' => $userId,
        ]);

         //item table data
        foreach ($data['items'] as $item) {
            $netAmount = $item['quantity'] * $item['unit_price'];
            $gstPercent = $item['gst_percent'] ?? 0;
            $gstAmount = $netAmount * $gstPercent/100;
            $total =  $netAmount + $gstAmount;
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'net_amount' => $netAmount,
                'gst_percent'=> $gstPercent,
                'gst_amount'=> $gstAmount,
                'total'=> $total,
                'created_by' => $userId,
            ]);
        }
        
        return $invoice;
    }


    //generate invoice id month wise
    public function generateInvoiceNumber( $invoiceDate)
    {
        // $date = $invoiceDate;
        $date = Carbon::parse($invoiceDate);
        $datePart = $date->format('Y-m');

        $count = invoice::whereYear('invoice_date', $date->year)
            ->whereMonth('invoice_date', $date->month)
            ->count() + 1;

        return 'INV-' . $datePart . '-' . $count;
    }



    public function storeCustomerWithAddress( $customerData,$userId)
    {

        //customer table data
        $customer = Customers::create([
            'customer_name' => $customerData['customer_name'],
            'customer_email' => $customerData['customer_email'],
            'contact_name' => $customerData['contact_name'] ?? null,
            'contact_number' => $customerData['contact_number'] ?? null,
            'created_by' => $userId,
        ]);

        //address table data
        $address = Addresses::create([
            'reference_id' => $customer->customer_id,
            'reference_name' => 'Customer',
            'line1' => $customerData['line1'],
            'line2' => $customerData['line2'] ?? null,
            'line3' => $customerData['line3'] ?? null,
            'line4' => $customerData['line4'] ?? null,
            'pincode' => $customerData['pincode'],
            'created_by' => $userId,
        ]);
        $customer->address_id = $address->address_id;
        $customer->save();
        return $customer;
    }




        //show invoice table data
        public function invoiceData(){
            $invoiceData = invoice::orderBy('invoice_id','desc')->paginate(5);
            return $invoiceData;
        }


        //Invoice Search
        public function searchField($request, $paginate=true){
            try{
                $startDate = isset($request['startDate']) && $request['startDate'] !== '' ? 
                              Carbon::parse($request['startDate']) : null;          
                $endDate = isset($request['endDate']) && $request['endDate'] !== '' ? 
                            Carbon::parse($request['endDate']): null;

                $invoiceNumber = $request['invoice_no'] ?? '';
                $inVoiceStatus = $request['invoice_status'] ?? '';
                $customer_id = $request['customer_id'] ?? '';

                $searchData = invoice::with(['status','customer'])                
                    ->when($startDate && !$endDate, function($searchData) use($startDate){
                        return $searchData->whereDate('invoice_date',$startDate);
                    })

                     ->when($startDate && $endDate, function($searchData)  use ($startDate,$endDate){
                        return $searchData->whereBetween('invoice_date', [$startDate, $endDate]);
                    })

                    ->when($invoiceNumber, function($searchData, $invoiceNumber){
                        return $searchData->where('invoice_no','LIKE','%' .$invoiceNumber. '%');
                    })

                    ->when($inVoiceStatus, function($searchData, $inVoiceStatus) {
                            return $searchData->where('invoice_status_id', $inVoiceStatus);
                        })

                    ->when($customer_id, function($searchData, $customer_id) {
                            return $searchData->where('customer_id', $customer_id);
                        });

                 /*Log::error($startDate);
                   Log::error($searchData->toSql());   
                   Log::error('SQL: ' . $searchData->getQuery()->toSql());
                   Log::error('SQL: ' . $searchData->getQuery()->toSql());*/ 
                   Log::error('Bindings: ' . json_encode($searchData->getQuery()->getBindings()));  

                if(!$paginate){
                    $searchData = $searchData->get();
                }else{
                    $searchData = $searchData->paginate(5);
                }                
                return $searchData;

            }catch(Exception $e){
                Log::error('invoice Search Error'. $e->getMessage());
            }
        }


        //Invoice status Table
        public function invoiceStatustable(){
            $status = InvoiceStatus::all();
            return $status;
        }

        //Customer table
        public function customerDataList(){
            $customer = Customers::all();
            return $customer;
        }

        //delete invoiceTable Data
        public function deleteInvoiceData($invoice_id){
                $invoiceData = invoice::findOrFail($invoice_id);
                $invoiceData->delete();
                return $invoiceData;
        }


        // public function exportInvoiceData(){
        //         try{
        //             return Excel::download(new InvoiceExport,'invoiceData.csv');
        //         }catch(Exception $e){
        //                 Log::error('invoice export Error'. $e->getMessage());
        //            } 
        // }           

}
