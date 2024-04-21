<?php


namespace App\Services;
use Stripe\Charge;
use Stripe\Invoice;
use Stripe\InvoiceItem;
use Stripe\Customer;

use App\Contracts\PaymentGatewayInterface;
use App\Models\User;

class StripeServices implements PaymentGatewayInterface {
    public function charge(array $details):bool 
    {

        ## BOC : Implementation of the stripe charge methods

        ## EOC
        return true;
    }
    public function createAccount(User $user,array $options=null):bool 
    {
        $user->createAsStripeCustomer($options);
        return true;
    }
}