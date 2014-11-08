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

class ChangeLog
{
    /** @var Entry[] */
    private $entries = [];

    /**
     * @param Entry $entry
     * @return $this
     */
    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;
        
        return $this;
    }

    /**
     * @return Entry[]
     */
    public function getEntries()
    {
        return $this->entries;
    }
}
