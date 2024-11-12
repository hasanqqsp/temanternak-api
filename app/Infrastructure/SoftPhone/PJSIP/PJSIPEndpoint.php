<?php

namespace App\Infrastructure\SoftPhone\PJSIP;

use Hidehalo\Nanoid\Client;
use Illuminate\Support\Facades\DB;

class PJSIPEndpoint
{
    public static function addEndpoint($username)
    {
        $password = (new Client())->generateId(8);
        try {
            DB::connection('mysql')->insert(
                'INSERT INTO ps_aors (id, max_contacts) VALUES (?, ?)',
                [$username, 20]
            );
        } catch (\Exception $e) {
            $password = (new Client())->generateId(8);
            DB::connection('mysql')->insert(
                'INSERT INTO ps_aors (id, max_contacts) VALUES (?, ?)',
                [$username, 20]
            );
        }

        DB::connection('mysql')->insert(
            'INSERT INTO ps_auths (id, auth_type, password, username) VALUES (?, ?, ?, ?)',
            [$username, 'userpass',  $password, $username]
        );

        DB::connection('mysql')->insert(
            'INSERT INTO ps_endpoints (id, transport, context, disallow, allow, aors, auth, webrtc, dtls_auto_generate_cert,media_encryption,dtls_verify,dtls_setup,dtls_rekey,rtcp_mux, rewrite_contact, direct_media ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [$username, 'transport-udp', 'from-internal', 'all', 'opus,ulaw,alaw,vp8,h264', $username, $username, 'yes', 'yes', 'dtls', 'fingerprint', 'actpass', '0', 'yes', 'yes', 'no']
        );
    }
    public static function removeEndpoint($username)
    {
        DB::connection('mysql')->delete(
            'DELETE FROM ps_endpoints WHERE id = ?',
            [$username]
        );

        DB::connection('mysql')->delete(
            'DELETE FROM ps_auths WHERE id = ?',
            [$username]
        );

        DB::connection('mysql')->delete(
            'DELETE FROM ps_aors WHERE id = ?',
            [$username]
        );
    }
    public static function getEndpoint($id)
    {
        $endpoint = DB::connection('mysql')->select(
            'SELECT id FROM ps_endpoints WHERE id = ? LIMIT 1',
            [$id]
        );
        if (empty($endpoint)) {
            throw new \Exception('Endpoint not found');
        }

        $auth = DB::connection('mysql')->select(
            'SELECT username, password FROM ps_auths WHERE id = ? LIMIT 1',
            [$id]
        );

        return [
            'id' => $endpoint[0]->id,
            'username' => $auth[0]->username,
            'password' => $auth[0]->password
        ];
    }
}
