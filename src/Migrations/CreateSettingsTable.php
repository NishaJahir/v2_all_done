<?php
/**
 * This file is used for creating Novalnet custom Settings table
 *
 * @author       Novalnet AG
 * @copyright(C) Novalnet
 * All rights reserved. https://www.novalnet.de/payment-plugins/kostenlos/lizenz
 */
namespace Novalnet\Migrations;

use Novalnet\Models\Settings;
use Plenty\Modules\Plugin\DataBase\Contracts\Migrate;

/**
 * Class CreateSettingsTable
 * 
 * @package Novalnet\Migrations
 */
class CreateSettingsTable
{
    /**
     * Create transaction log table
     *
     * @param Migrate $migrate
     */
    public function run(Migrate $migrate)
    {
        $migrate->createTable(Settings::class);
    }
}
