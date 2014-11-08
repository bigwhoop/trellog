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

class Entry
{
    /** @var string */
    public $version = '';
    
    /** @var \DateTime|null */
    public $date;
    
    /** @var Section[] */
    private $sections = [];

    /**
     * @param Section $section
     * @return $this
     */
    public function addSection(Section $section)
    {
        $this->sections[] = $section;
        
        return $this;
    }

    /**
     * @return Section[]
     */
    public function getSections()
    {
        return $this->sections;
    }
}
