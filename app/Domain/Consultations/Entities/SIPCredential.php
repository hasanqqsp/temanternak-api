<?php

namespace App\Domain\Consultations\Entities;

class SIPCredential
{
    private $sipServer;
    private $sipUri;
    private $sipUsername;
    private $sipPassword;
    private $sipTargetUri;

    public function __construct($sipUsername, $sipPassword, $veterinarianUsername)
    {
        $this->sipServer = env('SIP_SERVER');
        $this->sipUsername = $sipUsername;
        $this->sipUri = $this->sipUsername . '@' . env('SIP_FQDN');
        $this->sipPassword = $sipPassword;
        $this->sipTargetUri = $veterinarianUsername . '@' . env('SIP_FQDN');;
    }

    public function getSipServer()
    {
        return $this->sipServer;
    }

    public function getSipUri()
    {
        return $this->sipUri;
    }

    public function getSipUsername()
    {
        return $this->sipUsername;
    }

    public function getSipPassword()
    {
        return $this->sipPassword;
    }

    public function getSipTargetUri()
    {
        return $this->sipTargetUri;
    }
    public function toArray()
    {
        return [
            'sipServer' => $this->sipServer,
            'sipUri' => $this->sipUri,
            'sipUsername' => $this->sipUsername,
            'sipPassword' => $this->sipPassword,
            'sipTargetUri' => $this->sipTargetUri,
        ];
    }
}
