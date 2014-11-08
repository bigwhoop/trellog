<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Tests\Model;

use Bigwhoop\Trellog\Model\Section;
use Bigwhoop\Trellog\Model\Item;

class SectionTest extends \PHPUnit_Framework_TestCase
{
    public function testProperties()
    {
        $s = new Section();
        $s->name = 'foo bar';
        
        $this->assertSame('foo bar', $s->name);
    }
    
    public function testItems()
    {
        $s = new Section();
        $this->assertEmpty($s->getItems());
        
        $i1 = new Item();
        $s->addItem($i1);
        $this->assertCount(1, $s->getItems());
        $this->assertSame($i1, $s->getItems()[0]);
        
        $i2 = new Item();
        $s->addItem($i2);
        $this->assertCount(2, $s->getItems());
        $this->assertSame($i1, $s->getItems()[0]);
        $this->assertSame($i2, $s->getItems()[1]);
    }
}
