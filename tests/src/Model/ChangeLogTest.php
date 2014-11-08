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

use Bigwhoop\Trellog\Model\ChangeLog;
use Bigwhoop\Trellog\Model\Entry;

class ChangeLogTest extends \PHPUnit_Framework_TestCase
{
    public function testEntries()
    {
        $cl = new ChangeLog();
        $this->assertEmpty($cl->getEntries());
        
        $e1 = new Entry();
        $cl->addEntry($e1);
        $this->assertCount(1, $cl->getEntries());
        $this->assertSame($e1, $cl->getEntries()[0]);
        
        $e2 = new Entry();
        $cl->addEntry($e2);
        $this->assertCount(2, $cl->getEntries());
        $this->assertSame($e1, $cl->getEntries()[0]);
        $this->assertSame($e2, $cl->getEntries()[1]);
    }
}
