<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Services\InvoiceService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\invoice;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\InvoiceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{

    public function store(StoreInvoiceRequest $request, InvoiceService $invoiceService)
    {
        try {
            $userId = Auth::id();

          $validated= $request->validated();
    
            $invoice = $invoiceService->store($validated, $userId);

            if($invoice){
                return response()->json([
                    'status' => true,
                    'message' => 'Invoice created successfully.',
                    'invoice' => $invoice
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Failed To create Invoice.',
                ]);
            }
           
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating invoice: ' . $e->getMessage()
            ], 500);
        }
    }



    //generate pdf
    public function generatePdf(){

        $invoice = invoice::with('items')->latest('invoice_id')->first();

        if (!$invoice) {
            return response()->json(['message' => 'No invoice found.'], 404);
        }

        $pdf = Pdf::loadView('invoicePdf', ['invoice' => $invoice]);

        return $pdf->download('invoice-' . $invoice->invoice_no . '.pdf');
    }


    //store customer
    public function storeCustomerData(StoreCustomerRequest $request, InvoiceService $invoiceService){

    try {

        $userId = Auth::id();

        $validated = $request->validated();

        $customer = $invoiceService->storeCustomerWithAddress($validated, $userId);

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
            'data' => $customer,
        ]);

    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage(), 
        ], 500);
    }
}

        
        public function invoiceDataList(InvoiceService $invoiceData){
          try{
            $data = $invoiceData->invoiceData();
            if($data){
                return response()->json([
                    'success' => true,
                    'data' => InvoiceResource::collection($data),
                    'meta' =>[
                            'current_page' => $data->currentPage(),
                            'last_page'  => $data->lastPage(),
                            'per_page'  => $data->perPage()
                         ],
                 ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'something wrong'
                ]);
            }
           }catch(Exception $e){
              Log::error('Error In Invoicedata list' . $e->getMessage());
           } 
        }

    //Search Field in Invoive Table
     public function searchData(request $request, InvoiceService $invoiceSearchData){
        try{
            $requestData = $request->all();
            $search = $invoiceSearchData->searchField($requestData);
           
            //dd(, $searchData->getBindings());
            if($search){
                return response()->json([
                    'success' => true,
                    'data' => InvoiceResource::collection($search),
                    'meta' =>[
                                'current_page' => $search->currentPage(),
                                'last_page'  => $search->lastPage(),
                                'per_page'  => $search->perPage()
                             ],
                ]);
            }
          }catch(Exception $e){
                Log::error('error in search Data' . $e->getMessage());
          }
        }

        //invoice Status Table
    public function invoiceStatus(InvoiceService $invoiceStatusData){
        try{
            $invoiceData = $invoiceStatusData->invoiceStatustable();
            if($invoiceData){
                return response()->json([
                    'success' => true,
                    'data' => $invoiceData
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'error' => 'invoice status Not Found'
                ],401);
            }
           }catch(Exception $e){
                Log::error('error in get invoice Status' . $e->getMessage());
           } 
        }

}
