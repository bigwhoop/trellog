<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Tests\Config;

use Bigwhoop\Trellog\Model\ChangeLog;
use Bigwhoop\Trellog\Model\Entry;
use Bigwhoop\Trellog\Model\Item;
use Bigwhoop\Trellog\Model\Section;
use Bigwhoop\Trellog\Printer\KeepAChangelogPrinter;

class KeepAChangelogPrinterTest extends \PHPUnit_Framework_TestCase
{
    /** @var KeepAChangelogPrinter */
    private $printer;
    
    protected function setUp()
    {
        $this->printer = new KeepAChangelogPrinter();
        $this->printer->setOptions([
            'title' => 'MY CHANGELOG',
            'intro' => 'This is my CHANGELOG.',
        ]);
    }
    
    public function testFullChangeLog()
    {
        $changeLog = new ChangeLog();
        
        // ---
        
        $entry = new Entry();
        $entry->version = '1.1.0';
        $entry->date = new \DateTime('2014-12-03');
        $changeLog->addEntry($entry);
        
        $section = new Section();
        $section->name = 'Added';
        $entry->addSection($section);
        
        $item = new Item();
        $item->description = 'Item 3';
        $section->addItem($item);
        
        $item = new Item();
        $item->description = 'Item 4';
        $section->addItem($item);
        
        $section = new Section();
        $section->name = 'Removed';
        $entry->addSection($section);
        
        $item = new Item();
        $item->description = 'Item 5';
        $section->addItem($item);
        
        // ---
        
        $entry = new Entry();
        $entry->version = '1.0';
        $entry->date = new \DateTime('2014-12-01');
        $changeLog->addEntry($entry);
        
        $section = new Section();
        $section->name = 'Added';
        $entry->addSection($section);
        
        $item = new Item();
        $item->description = 'Item 1';
        $section->addItem($item);
        
        $item = new Item();
        $item->description = 'Item 2';
        $section->addItem($item);
        
        // ---
        
        $expected = <<<TXT
# MY CHANGELOG
This is my CHANGELOG.

## 1.1.0 - 2014-12-03
### Added
- Item 3
- Item 4

### Removed
- Item 5

## 1.0.0 - 2014-12-01
### Added
- Item 1
- Item 2

TXT;
        
        $this->assertSame($expected, $this->printer->printChangeLog($changeLog));
    }
}