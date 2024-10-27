<?php

namespace App\Services\Hash;

interface HashingServiceInterface
{
    /**
     * Hash the given value.
     *
     * @param string $value
     * @return string
     */
    public function make(string $value): string;

    /**
     * Verify the given value against the hash.
     *
     * @param string $value
     * @param string $hash
     * @return bool
     */
    public function check(string $value, string $hash): bool;

    /**
     * Determine if the hash needs to be rehashed.
     *
     * @param string $hash
     * @return bool
     */
    public function needRehash(string $hash): bool;
}
