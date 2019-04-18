<?php

if (!function_exists('str_contains')) {
    /**
     * @param string $str
     * @param mixed  $needles
     * @param bool   $sensitive
     */
    function str_contains(string $str, $needles, bool $sensitive = true): bool
    {
        $posHandler = $sensitive === true ? 'mb_strpos' : 'mb_stripos';
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && $posHandler($str, $needle) !== false) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('str_uuid')) {
    /**
     * @param int   $version
     * @param mixed $param1
     * @param mixed $param2
     */
    function str_uuid(int $version = 4, $param1 = null, $param2 = null): string
    {
        try {
            switch ($version) {
                case 5:
                    return Ramsey\Uuid\Uuid::uuid5($param1, $param2)->toString();
                    break;
                case 3:
                    return Ramsey\Uuid\Uuid::uuid3($param1, $param2)->toString();
                    break;
                case 1:
                    return Ramsey\Uuid\Uuid::uuid1($param1, $param2)->toString();
                    break;
                case 4:
                default:
                    return Ramsey\Uuid\Uuid::uuid4()->toString();
                    break;
            }
        } catch (Ramsey\Uuid\UnsatisfiedDependencyException $euuid) {
            throw $euuid;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
