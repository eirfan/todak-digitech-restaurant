<?php

namespace App\Contracts;

use App\Models\User;

interface PaymentGatewayInterface {
    public function charge(array $details):bool;
    public function createAccount(User $user,array $options=null):bool;
}
