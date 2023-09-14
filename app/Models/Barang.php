<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'FK_BRG';
    public $incrementing = false;

    protected $fillable = [
        'FK_BRG',
        'FN_BRG',
        'FK_JENIS',
        'FK_SAT',
        'FHARGA_HNA',
        'FHARGA_JUAL',
        'FPROFIT',
        'FSALDO',
        'FIN',
        'FOUT',
    ];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'FK_JENIS', 'FK_JENIS');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'FK_SAT', 'FK_SAT');
    }

    public function relasiSupplier()
    {
        return $this->hasMany(RelasiBarangSupplier::class, 'FK_BRG', 'FK_BRG');
    }
}
