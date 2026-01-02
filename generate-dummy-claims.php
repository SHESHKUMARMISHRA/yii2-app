<?php
require __DIR__ . '/vendor/autoload.php';

$faker = Faker\Factory::create();

// Docker MySQL hostname is "db"
$dsn = "mysql:host=db;dbname=yii2db;charset=utf8";
$username = "root";
$password = "root";

$pdo = new PDO($dsn, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Loop to insert dummy data...


for ($i = 1; $i <= 100; $i++) {
    $file_number = 'FN-' . str_pad($i, 3, '0', STR_PAD_LEFT);
    $manager_name = $faker->name;
    $service_provider = $faker->company;
    $claim_number = 'CL-' . mt_rand(1000, 9999);
    $assignment_id = 'AS-' . mt_rand(1000, 9999);
    $company_name = $faker->company;
    $invoice_date = $faker->date('Y-m-d', 'now');
    $expenses = $faker->randomFloat(2, 1000, 10000);
    $sales_tax = $expenses * 0.18;
    $payment_amount = $expenses - $faker->randomFloat(2, 100, 500);
    $balance_amount = $expenses - $payment_amount;
    $payment_date = $faker->date('Y-m-d', 'now');
    $loss_amount = $faker->randomFloat(2, 0, 1000);
    $details = $faker->sentence(10);

    $stmt = $pdo->prepare("INSERT INTO claim 
        (file_number, manager_name, service_provider, claim_number, assignment_id, company_name, invoice_date, expenses, sales_tax, payment_amount, balance_amount, payment_date, loss_amount, details) 
        VALUES 
        (:file_number, :manager_name, :service_provider, :claim_number, :assignment_id, :company_name, :invoice_date, :expenses, :sales_tax, :payment_amount, :balance_amount, :payment_date, :loss_amount, :details)");

    $stmt->execute([
        ':file_number' => $file_number,
        ':manager_name' => $manager_name,
        ':service_provider' => $service_provider,
        ':claim_number' => $claim_number,
        ':assignment_id' => $assignment_id,
        ':company_name' => $company_name,
        ':invoice_date' => $invoice_date,
        ':expenses' => $expenses,
        ':sales_tax' => $sales_tax,
        ':payment_amount' => $payment_amount,
        ':balance_amount' => $balance_amount,
        ':payment_date' => $payment_date,
        ':loss_amount' => $loss_amount,
        ':details' => $details,
    ]);
}

echo "100 dummy claims inserted successfully!\n";
