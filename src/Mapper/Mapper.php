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

use Bigwhoop\Trellog\Config\Configurable;
use Bigwhoop\Trellog\Config\SourceConfig;
use Bigwhoop\Trellog\Model\ChangeLog;
use Bigwhoop\Trellog\Model\Entry;
use Bigwhoop\Trellog\Model\Section;
use Bigwhoop\Trellog\Model\Item;
use Bigwhoop\Trellog\Trello\Client;
use Trello\Model\Card;
use Trello\Model\Lane;

abstract class Mapper
{
    use Configurable;

    /**
     * @param Client $trello
     * @param SourceConfig $source
     * @return Lane
     * @throws MapperException
     */
    public function retrieveList(Client $trello, SourceConfig $source)
    {
        $board = $trello->getBoard($source->boardId);
        $lists = $board->getLists([
            'fields' => 'id,name',
        ]);
        
        foreach ($lists as $list) {
            if ($list->id === $source->listId) {
                return $list;
            }
        }
        
        throw new MapperException("Could not find list {$source->listId} on board {$source->boardId}.");
    }
    
    /**
     * @param Lane $list
     * @return ChangeLog
     * @throws MapperException
     */
    abstract public function createChangeLog(Lane $list);
    
    /**
     * @param Card $card
     * @return Entry
     * @throws MapperException
     */
    abstract public function createEntry(Card $card);
    
    /**
     * @param array $checkList
     * @return Section
     * @throws MapperException
     */
    abstract public function createSection(array $checkList);
    
    /**
     * @param array $checkItem
     * @return Item
     * @throws MapperException
     */
    abstract public function createItem(array $checkItem);
}
