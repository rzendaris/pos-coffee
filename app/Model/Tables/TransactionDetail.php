<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class TransactionDetail extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'transaction_detail';

    protected $fillable = [
        'id',
        'transaction_id',
        'product_id',
        'qty',
        'unit_price',
        'ppn',
        'total_price',
        'is_delivered',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function branch()
    {
        return $this->belongsTo('App\Model\Tables\Branch', 'branch_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Model\Tables\Product', 'product_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Model\Tables\Transaction', 'transaction_id', 'id');
    }
}
