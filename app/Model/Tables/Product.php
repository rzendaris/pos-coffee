<?php

namespace App\Model\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class Product extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'product_name',
        'price',
        'stock',
        'sales',
        'category_id',
        'image',
        'handle_by',
        'branch_id',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function category()
    {
        return $this->belongsTo('App\Model\Tables\ProductCategory', 'category_id', 'id');
    }
}
