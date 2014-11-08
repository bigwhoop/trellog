<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Config;

use Symfony\Component\Yaml\Yaml;

abstract class Config
{
    /**
     * @param string $filePath
     * @return Config
     */
    public static function load($filePath)
    {
        $contents = file_get_contents($filePath);
        $data = Yaml::parse($contents);
        
        $config = new static();
        $config->fromArray($data);
        return $config;
    }
    
    /**
     * @param string $filePath
     */
    public function save($filePath)
    {
        $yaml = Yaml::dump($this->toArray(), 4, 2);
        file_put_contents($filePath, $yaml);
    }

    /**
     * @param array $data
     */
    public function fromArray(array $data)
    {
        $reflection = new \ReflectionClass($this);
        
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $key = $property->getName();
            
            if (array_key_exists($key, $data)) {
                $value = $data[$key];
                
                if ($this->$key instanceof Config) {
                    $this->$key->fromArray($value);
                } else {
                    $this->$key = $value;
                }
            }
        }
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        $reflection = new \ReflectionClass($this);
        
        $a = [];
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $key = $property->getName();
            
            $value = $this->$key;
            if ($value instanceof Config) {
                $value = $value->toArray();
            }
            $a[$key] = $value;
        }
        
        return $a;
    }
}
