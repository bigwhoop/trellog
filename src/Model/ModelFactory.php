<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Model;

use Trello\Model\Card;
use Trello\Model\Lane;

abstract class ModelFactory
{
    /**
     * @param Lane $list
     * @return ChangeLog
     */
    abstract public function createChangeLog(Lane $list);
    
    /**
     * @param Card $card
     * @return Entry
     */
    abstract public function createEntry(Card $card);
    
    /**
     * @param array $checklist
     * @return Section
     */
    abstract public function createSection(array $checklist);
    
    /**
     * @param array $checkItem
     * @return Item
     */
    abstract public function createItem(array $checkItem);
}
