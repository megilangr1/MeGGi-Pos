<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'FNO_REF';
    public $incrementing = false;

    protected $fillable = [
        'FNO_REF',
        'FNO_PO',
        'FKD_RLS',
        'FHARGA',
        'FQ_PO',
    ];
}
