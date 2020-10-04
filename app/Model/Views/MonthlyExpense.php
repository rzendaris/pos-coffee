<?php

namespace App\Model\Views;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of UserGroup
 *
 * @author NawaTech
 */
class MonthlyExpense extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = 'view_monthly_expense';

    protected $fillable = [
        'year',
        'month',
        'day',
        'branch_id',
        'total_expense'
    ];
}
