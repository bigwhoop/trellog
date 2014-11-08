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

use Bigwhoop\Trellog\Model\ChangeLog;
use Bigwhoop\Trellog\Model\Entry;
use Bigwhoop\Trellog\Model\Item;
use Bigwhoop\Trellog\Model\Section;

abstract class Printer
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
     * @return null
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
    
    /**
     * @param ChangeLog $changeLog
     * @return string
     */
    abstract public function printChangeLog(ChangeLog $changeLog);
    
    /**
     * @param Entry $entry
     * @return string
     */
    abstract public function printEntry(Entry $entry);
    
    /**
     * @param Section $section
     * @return string
     */
    abstract public function printSection(Section $section);
    
    /**
     * @param Item $item
     * @return string
     */
    abstract public function printItem(Item $item);
}
