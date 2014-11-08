<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Trello;

use Trello\Client as Trello;
use Trello\Model\Board;
use Trello\Model\Lane;
use Trello\Model\Member;

class Client extends Trello
{
    /**
     * @return Member
     */
    public function getMe()
    {
        $member = new Member($this);
        $member->setId('me');
        
        return $member->get();
    }

    /**
     * @return Board[]
     */
    public function getMyBoards()
    {
        return $this->getMe()->getBoards();
    }

    /**
     * @return array
     */
    public function getMyBoardsAsArray()
    {
        $arr = [];
        foreach ($this->getMyBoards() as $board) {
            $arr[$board->id] = $board->name;
        }
        asort($arr);
        
        return $arr;
    }

    /**
     * @param string $boardId
     * @return Lane[]
     */
    public function getListsForBoard($boardId)
    {
        $board = new Board($this);
        $board->setId($boardId);
        
        /** @var Board $board */
        $board = $board->get();
        
        return $board->getLists();
    }

    /**
     * @param string $boardId
     * @return array
     */
    public function getListsForBoardAsArray($boardId)
    {
        $arr = [];
        foreach ($this->getListsForBoard($boardId) as $list) {
            $arr[$list->id] = $list->name;
        }
        asort($arr);
        
        return $arr;
    }
}
