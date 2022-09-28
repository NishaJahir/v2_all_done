<?php
/**
 * This file is used for displaying the Google Pay button
 *
 * @author       Novalnet AG
 * @copyright(C) Novalnet
 * All rights reserved. https://www.novalnet.de/payment-plugins/kostenlos/lizenz
 */
namespace Novalnet\Providers\DataProvider;

use Plenty\Plugin\Templates\Twig;
use Plenty\Modules\Basket\Models\Basket;
use Plenty\Modules\Basket\Contracts\BasketRepositoryContract;
use Novalnet\Helper\PaymentHelper;
use Plenty\Modules\Frontend\Session\Storage\Contracts\FrontendSessionStorageFactoryContract;
use Novalnet\Services\PaymentService;
use Novalnet\Services\SettingsService;

/**
 * Class NovalnetGooglePayButtonDataProvider
 *
 * @package Novalnet\Providers\DataProvider
 */
class NovalnetGooglePayButtonDataProvider
{
    /**
     * Display the Google Pay button
     *
     * @param Twig $twig
     * @param BasketRepositoryContract $basketRepository
     * @param Arguments $arg
     * 
     * @return string
     */
    public function call(Twig $twig, 
                         BasketRepositoryContract $basketRepository,
                         $arg)
    {
        $basket             = $basketRepository->load();
        $paymentHelper      = pluginApp(PaymentHelper::class);
        $sessionStorage     = pluginApp(FrontendSessionStorageFactoryContract::class);
        $paymentService     = pluginApp(PaymentService::class);
        $settingsService    = pluginApp(SettingsService::class);
        
        $orderAmount = 0;
        if(!empty($basket->basketAmount)) {
            // Get the order total basket amount
            $orderAmount = $paymentHelper->convertAmountToSmallerUnit($basket->basketAmount);
        }
        // Get the Payment MOP Id
        $paymentMethodDetails = $paymentHelper->getPaymentMethodByKey('NOVALNET_GOOGLEPAY');
        // Get the order language
        $orderLang = strtoupper($sessionStorage->getLocaleSettings()->language);
        // Required details for the Google Pay button
        $googlePayData = [
                            'clientKey'     => trim($settingsService->getPaymentSettingsValue('novalnet_client_key')),
                            'MerchantId'    => $settingsService->getPaymentSettingsValue('payment_active', 'novalnet_google_pay'),
                            'sellerName'    => $settingsService->getPaymentSettingsValue('business_name', 'novalnet_google_pay'),
                            'enforce'       => $settingsService->getPaymentSettingsValue('enforce', 'novalnet_google_pay'),
                            'buttonType'    => $settingsService->getPaymentSettingsValue('button_type', 'novalnet_google_pay'),
                            'buttonTheme'   => $settingsService->getPaymentSettingsValue('button_theme', 'novalnet_google_pay'),
                            'buttonHeight'  => $settingsService->getPaymentSettingsValue('button_height', 'novalnet_google_pay'),
                            'testMode'      => ($settingsService->getPaymentSettingsValue('test_mode', 'novalnet_google_pay') == true) ? 'SANDBOX' : 'PRODUCTION'
                         ];
        // Render the Google Pay button
       return $twig->render('Novalnet::PaymentForm.NovalnetGooglePayButton', 
                                    [
                                        'mopId'                 => $paymentMethodDetails->id, 
                                        'googlePayData'         => $googlePayData, 
                                        'countryCode'           => 'DE', 
                                        'orderTotalAmount'      => $orderAmount, 
                                        'orderLang'             => $orderLang, 
                                        'orderCurrency'         => $basket->currency, 
                                        'nnPaymentProcessUrl'   => $paymentService->getProcessPaymentUrl()
                                    ]);
    }
}
