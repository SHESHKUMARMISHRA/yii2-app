<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%claim}}`.
 */
class m260102_142651_create_claim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%claim}}', [
            'id' => $this->primaryKey(),
            'file_number' => $this->string(50),
            'manager_name' => $this->string(),
            'service_provider' => $this->string(),
            'claim_number' => $this->string(50),
            'assignment_id' => $this->string(50),
            'company_name' => $this->string(),

            'invoice_date' => $this->date(),
            'expenses' => $this->decimal(10,2),
            'sales_tax' => $this->decimal(10,2),
            'payment_amount' => $this->decimal(10,2),
            'balance_amount' => $this->decimal(10,2),
            'payment_date' => $this->date(),
            'loss_amount' => $this->decimal(10,2),

            'details' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%claim}}');
    }
}
