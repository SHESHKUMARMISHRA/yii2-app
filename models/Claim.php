<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class Claim extends ActiveRecord
{
    // public $file_number;
    // public $manager_name;
    // public $service_provider;
    // public $claim_number;
    // public $assignment_id;
    // public $company_name;
    // public $invoice_date;
    // public $expenses;
    // public $sales_tax;
    // public $payment_amount;
    // public $balance_amount;
    // public $payment_date;
    // public $loss_amount;

    public static function tableName()
    {
        return 'claim';
    }
}
