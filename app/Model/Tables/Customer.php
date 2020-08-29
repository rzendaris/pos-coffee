<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class Customer extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'customers';

    protected $fillable = [
        'id',
        'branch_id',
        'customer_name',
        'customer_code',
        'address',
        'telp',
        'company',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Model\Tables\Branch', 'branch_id', 'id');
    }
}
