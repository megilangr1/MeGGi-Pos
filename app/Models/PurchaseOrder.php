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

    public function detail()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'FNO_PO', 'FNO_PO');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'FK_SUP', 'FK_SUP');
    }
}
