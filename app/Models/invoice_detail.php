<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_detail extends Model
{
    use HasFactory;
    protected $fillable =[
            'id_invoice' ,
            'invoice_number' ,
            'product' ,
            'section' ,
            'status',
            'value_status',
            'note' ,
            'user' ,
            'Paymnt_Date',

    ];


    public function pay(){

        return $this->belongsTo('App\Models\Payment','id_invoice');

    }

}
