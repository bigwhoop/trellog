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

class StandardModelFactory extends ModelFactory
{
    /**
     * @param Lane $list
     * @return ChangeLog
     */
    public function createChangeLog(Lane $list)
    {
        $changeLog = new ChangeLog();
        
        $cards = $list->getCards([
            'fields' => 'id,name,due',
            'checklists' => 'all',
        ]);
        
        foreach ($cards as $card) {
            $changeLog->addEntry($this->createEntry($card));
        }
        
        return $changeLog;
    }
    
    /**
     * @param Card $card
     * @return Entry
     */
    public function createEntry(Card $card)
    {
        $entry = new Entry();
        $entry->version = $card->name;
        $entry->date = new \DateTime($card->due);
        
        foreach ($card->checklists as $checklist) {
            $entry->addSection($this->createSection($checklist));
        }
        
        return $entry;
    }
    
    /**
     * @param array $checklist
     * @return Section
     */
    public function createSection(array $checklist)
    {
        $section = new Section();
        $section->name = $checklist['name'];
        
        foreach ($checklist['checkItems'] as $checkItem) {
            $section->addItem($this->createItem($checkItem));
        }
        
        return $section;
    }
    
    /**
     * @param array $checkItem
     * @return Item
     */
    public function createItem(array $checkItem)
    {
        $item = new Item();
        $item->description = $checkItem['name'];
        
        return $item;
    }
}
