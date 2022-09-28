<?php
/**
 * This module is used for registering the routes
 *
 * @author       Novalnet AG
 * @copyright(C) Novalnet
 * All rights reserved. https://www.novalnet.de/payment-plugins/kostenlos/lizenz
 */
namespace Novalnet\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

/**
 * Class NovalnetRouteServiceProvider
 *
 * @package Novalnet\Providers
 */
class NovalnetRouteServiceProvider extends RouteServiceProvider
{
    /**
     * Set route for success, failure payment and webhook process
     *
     * @param Router $router
     */
    public function map(Router $router)
    {
        // Get the Novalnet success, cancellation, reinitialize payment and callback URLs
        $router->match(['post', 'get'], 'payment/novalnet/webhook', 'Novalnet\Controllers\WebhookController@processWebhook');
        $router->match(['post', 'get'], 'payment/novalnet/processPayment', 'Novalnet\Controllers\PaymentController@processPayment');
        $router->get('payment/novalnet/paymentResponse', 'Novalnet\Controllers\PaymentController@paymentResponse');
        $router->get('payment/novalnet/directPaymentProcess', 'Novalnet\Controllers\PaymentController@directPaymentProcess');
    }
}
