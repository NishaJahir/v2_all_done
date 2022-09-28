<?php
/**
 * This file is used for updating Novalnet custom table
 *
 * @author       Novalnet AG
 * @copyright(C) Novalnet
 * All rights reserved. https://www.novalnet.de/payment-plugins/kostenlos/lizenz
 */
namespace Novalnet\Migrations;

use Novalnet\Models\TransactionLog;
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;

/**
 * Class UpdateTransactionTableDataType
 * 
 * @package Novalnet\Migrations
 */
class UpdateTransactionTableDataType
{
    /**
     * Create transaction log table
     *
     * @param Migrate $migrate
     */
    public function run(Migrate $migrate)
    {
        $migrate->updateTable(TransactionLog::class);
    }
}
