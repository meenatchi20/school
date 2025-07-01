<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'invoice_id' => $this->invoice_id,
            'invoice_no' => $this->invoice_no,
            'invoice_date' => $this->invoice_date,
            'invoice_due_date' => $this->invoice_due_date,
            'total_amount' => $this->total_amount,
            'balance_amount' =>$this->balance_amount ,
            'invoice_status' => $this->status ? [
                'id' => $this->invoice_status_id,
                'status' => $this->status->invoice_status
            ] : null
        ];
    }
}
