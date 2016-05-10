<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Mapper;

use Bigwhoop\Trellog\Trello\Client;

final class MapperFactory
{
    /**
     * @param string $mapperClass
     * @param array $options
     * @param Client $client
     * @return Mapper
     * @throws \InvalidArgumentException
     */
    public static function create($mapperClass, array $options, Client $client)
    {
        if (!class_exists($mapperClass, true)) {
            throw new \InvalidArgumentException("Mapper class '$mapperClass' must exist.");
        }
        
        $obj = new $mapperClass($client);
        if (!($obj instanceof Mapper)) {
            throw new \InvalidArgumentException("Class '" . get_class($obj) . "' must be an instance of '" . Mapper::class . "'.");
        }
        
        $obj->setOptions($options);
        
        return $obj;
    }
}
