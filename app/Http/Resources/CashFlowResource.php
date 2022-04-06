<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashFlowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'date' => $this->date,
            'category_id' => $this->category_id,
            'category' => $this->category->name,
            'subcategory_id' => $this->sub_category_id,
            'subcategory' => $this->sub_category->name,
            'amount' => $this->amount,
            'amount' => $this->amount,
            'remarks' => $this->remarks
        ];

    }
}
