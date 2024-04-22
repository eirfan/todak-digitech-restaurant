<?php 

namespace App\Traits;

trait ErrorTraits{
    public function parseValidationError(array $errors) {
        $tempError ="Error :";
        foreach($errors as $key=>$error) {
            $tempError = $tempError." ".$error;
        };
        return $tempError;
    }
}