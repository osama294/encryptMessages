<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class EncryptionService
{
    public function encrypt($data)
    {
        // Encrypt the data using Laravel's encryption facilities
        return Crypt::encrypt($data);
    }

    public function decrypt($data)
    {
     // Decrypt the data using Laravel's decryption facilities
        return Crypt::decrypt($data);
    }
}
