<?php

namespace Libraries\Utilities;

class PasswordUtils
{

    /**
     * Creates a password hash with blowfish algorithm
     * @param string $password
     * @param int $cost
     * @return string
     */
    public static function hashPassword(string $password, int $cost = 10): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);
    }

    /**
     * Generate a pseudo-random string of bytes and return as bytes or hexadecimal string
     * @param int $lengthInBytes
     * @return string
     */
    public static function token(int $lengthInBytes = 20, bool $returnAsHex = true): string
    {
        $bytes = openssl_random_pseudo_bytes($lengthInBytes);

        if (!$returnAsHex) {
            return $bytes;
        }

        return bin2hex($bytes);
    }

    /**
     * Generate random password
     * @param int $length
     * @param string $availableSets
     * @return string
     */
    public static function randomPassword(int $length = 8, string $availableSets = 'luds'): string
    {
        $sets = [];

        if (strpos($availableSets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if (strpos($availableSets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($availableSets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($availableSets, 's') !== false)
            $sets[] = '!@#$%&*?';

        $all = '';
        $password = '';

        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);

        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];

        $password = str_shuffle($password);

        return $password;
    }

    /**
     * @param string $password
     * @return string
     */
    public static function gnuCryptHash(string $password): string
    {
        $salt = '$1$' . self::randomPassword(8, 'lud') . '$';
        return crypt($password, $salt);
    }

    /**
     * @param string $password
     * @return string
     */
    public static function NTHash(string $password): string
    {
        // Convert the password from UTF8 to UTF16 (little endian)
        $password = iconv('UTF-8', 'UTF-16LE', $password);
        $MD4Hash = hash('md4', $password);
        $NTLMHash = strtoupper($MD4Hash);

        return ($NTLMHash);
    }

    /**
     * @param string $password
     * @return string
     */
    public static function LMHash(string $password): string
    {
        $password = strtoupper(substr($password, 0, 14));

        $p1 = self::LMhashDESencrypt(substr($password, 0, 7));
        $p2 = self::LMhashDESencrypt(substr($password, 7, 7));

        return strtoupper($p1 . $p2);
    }

    /**
     * @param string $password
     * @return string
     */
    private static function LMhashDESencrypt(string $password): string
    {
        $key = array();
        $tmp = array();
        $len = strlen($password);

        for ($i = 0; $i < 7; ++$i)
            $tmp[] = $i < $len ? ord($password[$i]) : 0;

        $key[] = $tmp[0] & 254;
        $key[] = ($tmp[0] << 7) | ($tmp[1] >> 1);
        $key[] = ($tmp[1] << 6) | ($tmp[2] >> 2);
        $key[] = ($tmp[2] << 5) | ($tmp[3] >> 3);
        $key[] = ($tmp[3] << 4) | ($tmp[4] >> 4);
        $key[] = ($tmp[4] << 3) | ($tmp[5] >> 5);
        $key[] = ($tmp[5] << 2) | ($tmp[6] >> 6);
        $key[] = $tmp[6] << 1;

        $is = mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($is, MCRYPT_RAND);
        $key0 = "";

        foreach ($key as $k)
            $key0 .= chr($k);

        $crypt = mcrypt_encrypt(MCRYPT_DES, $key0, "KGS!@#$%", MCRYPT_MODE_ECB, $iv);

        return bin2hex($crypt);
    }

}
