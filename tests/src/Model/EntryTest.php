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

use Bigwhoop\Trellog\Model\Entry;
use Bigwhoop\Trellog\Model\Section;

class EntryTest extends \PHPUnit_Framework_TestCase
{
    public function testProperties()
    {
        $date = new \DateTime('2014-12-01');
        
        $e = new Entry();
        $e->version = '1.2.3';
        $e->date = $date;
        
        $this->assertSame('1.2.3', $e->version);
        $this->assertSame($date, $e->date);
    }
    
    public function testSections()
    {
        $e = new Entry();
        $this->assertEmpty($e->getSections());
        
        $s1 = new Section();
        $e->addSection($s1);
        $this->assertCount(1, $e->getSections());
        $this->assertSame($s1, $e->getSections()[0]);
        
        $s2 = new Section();
        $e->addSection($s2);
        $this->assertCount(2, $e->getSections());
        $this->assertSame($s1, $e->getSections()[0]);
        $this->assertSame($s2, $e->getSections()[1]);
    }
}
