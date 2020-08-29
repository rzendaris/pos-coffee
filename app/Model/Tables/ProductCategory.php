<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class ProductCategory extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'product_category';

    protected $fillable = [
        'id',
        'category_name',
        'description',
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
