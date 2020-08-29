<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class Payment extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'payment';

    protected $fillable = [
        'id',
        'transaction_number',
        'payment_method',
        'bank_account',
        'amount_paid',
        'number_account',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function transaction()
    {
        return $this->belongsTo('App\Model\Tables\Transaction', 'transaction_number', 'transaction_number');
    }
}
