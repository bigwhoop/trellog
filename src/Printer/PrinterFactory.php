<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Printer;

final class PrinterFactory
{
    /**
     * @param string $class
     * @param array $options
     * @return Printer
     * @throws \InvalidArgumentException
     */
    public static function create($class, array $options)
    {
        if (!class_exists($class, true)) {
            throw new \InvalidArgumentException("Printer class '$class' must exist.");
        }
        
        $obj = new $class();
        if (!($obj instanceof Printer)) {
            throw new \InvalidArgumentException("Class '" . get_class($obj) . "' must be an instance of '" . Printer::class . "'.");
        }
        
        $obj->setOptions($options);
        
        return $obj;
    }
}
