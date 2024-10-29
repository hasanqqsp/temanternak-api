<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class GeneralIdentity extends Model
{
    // Class implementation goes here
    public function ktpFile()
    {
        return $this->hasOne(UserFile::class, 'id', 'ktp_file_id');
    }
    public function formalPhoto()
    {
        return $this->hasOne(UserFile::class, 'id', 'formal_picture_id');
    }
}
