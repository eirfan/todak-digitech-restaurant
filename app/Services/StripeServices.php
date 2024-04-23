<?php


namespace App\Services;
use Stripe\Charge;
use Stripe\Invoice;
use Stripe\InvoiceItem;
use Stripe\Customer;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Invoices;
use App\Models\User;

class StripeServices implements PaymentGatewayInterface {
    public function charge(Invoices $invoice,User $user):bool 
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