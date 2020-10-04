<?php

namespace App\Model\Views;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class MonthlySales extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'view_monthly_sales';

    protected $fillable = [
        'year',
        'month',
        'day',
        'branch_id',
        'total_sales'
    ];
}
