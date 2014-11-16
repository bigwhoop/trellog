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

use Bigwhoop\Trellog\Config\Configurable;
use Bigwhoop\Trellog\Model\ChangeLog;
use Bigwhoop\Trellog\Model\Entry;
use Bigwhoop\Trellog\Model\Item;
use Bigwhoop\Trellog\Model\Section;

abstract class Printer
{
    use Configurable;
    
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
