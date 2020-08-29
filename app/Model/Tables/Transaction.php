<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class Transaction extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'transaction';

    protected $fillable = [
        'id',
        'transaction_number',
        'branch_id',
        'item_qty',
        'total_discount',
        'total_ppn',
        'total_price',
        'total_amount_paid',
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

    public function transaction_detail()
    {
        return $this->hasMany('App\Model\Tables\TransactionDetail', 'transaction_id', 'id');
    }

    public function transaction_payment()
    {
        return $this->hasMany('App\Model\Tables\Payment', 'transaction_number', 'transaction_number');
    }
}
