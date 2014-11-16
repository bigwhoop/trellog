<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Util;

class ArrayArgument
{
    /**
     * @param string $label
     * @param array $requiredKeys
     * @param $array
     */
    public static function requireKeys($label, array $requiredKeys, $array)
    {
        $errorMessage = sprintf(
            '%s must be an array having the following keys: %s',
            $label,
            join(', ', $requiredKeys)
        );
        
        $exception = new \InvalidArgumentException($errorMessage);
        
        if (!is_array($array)) {
            throw $exception;
        }
        
        foreach ($requiredKeys as $requiredKey) {
            if (!array_key_exists($requiredKey, $array)) {
                throw $exception;
            }
        }
    }
}
