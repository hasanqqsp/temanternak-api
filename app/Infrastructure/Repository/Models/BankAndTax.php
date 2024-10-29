<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class BankAndTax extends Model
{
    // Class implementation goes here
    public function bankAccountFile()
    {
        return $this->hasOne(UserFile::class, 'id', 'back_account_file_id');
    }
}
