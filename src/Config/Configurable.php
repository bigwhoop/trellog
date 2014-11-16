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

trait Configurable
{
    /** @var array */
    protected $defaultOptions = [];
    
    /** @var array */
    private $options = [];

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $this->setOption($key, $value);
        }
        
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getOption($key, $default = null)
    {
        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        }
        
        if (array_key_exists($key, $this->defaultOptions)) {
            return $this->defaultOptions[$key];
        }
        
        return $default;
    }
}
