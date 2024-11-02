<?php

namespace App\Domain\VeterinarianVerifications\Entities;

class AddedVeterinarianVerification
{
    private $registrationId;
    private $status;

    public function __construct($registrationId, $status)
    {
        $this->registrationId = $registrationId;
        $this->status = $status;
    }

    public function getRegistrationId()
    {
        return $this->registrationId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setRegistrationId($registrationId)
    {
        $this->registrationId = $registrationId;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function toArray()
    {
        return [
            'registrationId' => $this->registrationId,
            'status' => $this->status,
        ];
    }
}
