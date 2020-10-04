<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class Expense extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'expense';

    protected $fillable = [
        'id',
        'name',
        'qty',
        'measure',
        'price',
        'image',
        'branch_id',
        'description',
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
}
