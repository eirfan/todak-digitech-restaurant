<?php


namespace App\Services;
use Stripe\Charge;
use Stripe\Invoice;
use Stripe\InvoiceItem;
use Stripe\Customer;
use App\Contracts\PaymentGatewayInterface;
use App\Models\Invoices;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeServices implements PaymentGatewayInterface {
    public function charge(Invoices $invoice,User $user):bool 
    {
        $paymentMethod = $this->getLatestPaymentMethod($user);
        $paymentIntent =PaymentIntent::create([
            'amount'=>intval($invoice->total*100),
            'currency'=>'myr',
            'payment_method_types'=>['card'],
            'customer'=>$user->stripe_id
        ]);
        $confirmedPaymentIntent = $paymentIntent->confirm([
            'payment_method'=>$paymentMethod['id'],
        ]);
        if(!isset($confirmedPaymentIntent)) {
            throw new Exception("Cannot complete the payment");
        }
        return true;
    }
    public function createAccount(User $user,array $options=null):bool 
    {
        if(!$options) $options = [];
        $user->createAsStripeCustomer($options);
        return true;
    }
    public function getLatestPaymentMethod (User $user) {
        $paymentMethod = Customer::allPaymentMethods($user->stripe_id);
        return $paymentMethod->data[0];
    }
}