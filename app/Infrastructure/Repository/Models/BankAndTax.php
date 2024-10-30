<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class BankAndTax extends Model
{
    // Class implementation goes here
    public function bankAccountFile()
    {
        return $this->hasOne(UserFile::class, 'id', 'bank_account_file_id');
    }

    public function npwpFile()
    {
        return $this->hasOne(UserFile::class, 'id', 'npwp_file_id');
    }
}
