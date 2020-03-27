<?php

/**
 * Конвертирует строку в hex цвет
 *
 * @param string $str
 * @return string
 */
function stringToColorHex(string $str) : string
{
    $code = dechex(crc32($str));

    return '#' . substr($code, 0, 6);
}
