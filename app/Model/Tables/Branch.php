<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class Branch extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'branch';

    protected $fillable = [
        'id',
        'branch_name',
        'address',
        'telp',
        'email',
        'fax',
        'head_office',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    // public function template()
    // {
    //     return $this->belongsTo('App\Models\Tables\Template', 'template_id', 'id');
    // }
}
