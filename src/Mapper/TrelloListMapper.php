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

use Bigwhoop\Trellog\Model\ChangeLog;
use Bigwhoop\Trellog\Model\Entry;
use Bigwhoop\Trellog\Model\Item;
use Bigwhoop\Trellog\Model\Section;
use Bigwhoop\Trellog\Util\ArrayArgument;
use Trello\Model\Card;
use Trello\Model\Lane;

class TrelloListMapper extends Mapper
{
    /**
     * {@inheritdoc}
     */
    public function createChangeLog(Lane $list)
    {
        $changeLog = new ChangeLog();
        
        $cards = $list->getCards([
            'fields' => 'id,name,due',
            'checklists' => 'all',
            'filter' => $this->getOption('include_archived_cards', false) ? 'all' : 'open',
        ]);
        
        foreach ($cards as $card) {
            $changeLog->addEntry($this->createEntry($card));
        }
        
        return $changeLog;
    }
    
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function createSection(array $checkList)
    {
        ArrayArgument::requireKeys('First argument', ['name', 'checkItems'], $checkList);
        
        $section = new Section();
        $section->name = $checkList['name'];
        
        foreach ((array)$checkList['checkItems'] as $checkItem) {
            $section->addItem($this->createItem($checkItem));
        }
        
        return $section;
    }
    
    /**
     * {@inheritdoc}
     */
    public function createItem(array $checkItem)
    {
        ArrayArgument::requireKeys('First argument', ['name'], $checkItem);
        
        $description = $checkItem['name'];
        
        if ($this->getOption('follow_trello_urls', true)) {
            $matches = [];
            if (preg_match('|^https://trello\.com/c/([a-zA-Z0-9]+)/[0-9]+\-|', $checkItem['name'], $matches)) {
                $cardId = $matches[1];
                try {
                    $card = $this->client->getCard($cardId);
                    $description = $card->name;
                } catch (\Exception $e) {
                    // ignore invalid URL
                }
            }
        }
        
        $item = new Item();
        $item->description = $description;
        
        return $item;
    }
}
