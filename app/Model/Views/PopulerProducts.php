<?php

namespace App\Model\Views;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class PopulerProducts extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'view_populer_products';

    protected $fillable = [
        'product_name_popular',
        'sales_qty'
    ];
}
