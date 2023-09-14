<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'FNO_PO';
    public $incrementing = false;
    
    protected $fillable = [
        'FNO_PO',
        'FTGL_PO',
        'FK_SUP',
        'FKET',
    ];
}
