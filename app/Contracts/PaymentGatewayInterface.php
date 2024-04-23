<?php

namespace App\Contracts;

use App\Models\Invoices;
use App\Models\User;

interface PaymentGatewayInterface {
    public function charge(Invoices $invoice,User $user):bool;
    public function createAccount(User $user,array $options=null):bool;
}
