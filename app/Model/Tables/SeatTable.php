<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class SeatTable extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'seat_table';

    protected $fillable = [
        'id',
        'seat_no',
        'location',
        'branch_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Model\Tables\Branch', 'branch_id', 'id');
    }
}
