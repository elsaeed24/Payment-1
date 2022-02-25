<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

   // protected $guarded=[];

   protected $fillable =[
    'invoice_number' ,
    'invoice_Date',
    'Due_date',
    'product',
    'section_id',
    'Amount_collection',
    'Amount_comission',
    'Discount',
    'Value_Vat',
    'Rate_Vat',
    'total',
    'status',
    'value_status',
    'note',
    'payment_Date'
   ];

   public function section(){

    return $this->belongsTo('App\Models\Section');

}

}
