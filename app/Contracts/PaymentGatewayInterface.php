<?php

namespace App\Contracts;

use App\Models\Invoices;
use App\Models\User;
use Stripe\Collection;

interface PaymentGatewayInterface {
    public function charge(Invoices $invoice,User $user):bool;
    public function createAccount(User $user,array $options=null):bool;
    public function getLatestPaymentMethod(User $user);
}
