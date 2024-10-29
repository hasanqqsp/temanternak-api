<?php

namespace App\Infrastructure\Repository\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    // Class implementation goes here
    public function strvFile()
    {
        return $this->hasOne(UserFile::class, 'id', 'strv_file_id');
    }
    public function sipFile()
    {
        return $this->hasOne(UserFile::class, 'id', 'sip_file_id');
    }
}
