<?php

namespace App\Domain\Users;

interface UserFilesRepository
{
    public function find($id);
    public function findAll();
    public function save($userFile);
    public function delete($id);
}
