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


use Bigwhoop\Trellog\Model\StandardModelFactory;
use Bigwhoop\Trellog\Model\ChangeLog;
use Bigwhoop\Trellog\Model\Entry;
use Bigwhoop\Trellog\Model\Section;
use Bigwhoop\Trellog\Model\Item;

class StandardModelFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var StandardModelFactory */
    private $factory;
    
    protected function setUp()
    {
        $this->factory = new StandardModelFactory();
    }
    
    public function testCreateSection()
    {
        $section = $this->factory->createSection([
            'name' => 'Added',
            'checkItems' => [
                ['name' => 'Some feature'],
                ['name' => 'Some other feature'],
            ]
        ]);
        
        $this->assertInstanceOf(Section::class, $section);
        $this->assertSame('Added', $section->name);
        
        $this->assertCount(2, $section->getItems());
        $this->assertInstanceOf(Item::class, $section->getItems()[0]);
        $this->assertSame('Some feature', $section->getItems()[0]->description);
        $this->assertInstanceOf(Item::class, $section->getItems()[1]);
        $this->assertSame('Some other feature', $section->getItems()[1]->description);
    }
    
    public function testCreateItem()
    {
        $factory = new StandardModelFactory();
        $item = $this->factory->createItem(['name' => 'Fixed the problem.']);
        
        $this->assertInstanceOf(Item::class, $item);
        $this->assertSame('Fixed the problem.', $item->description);
    }
}
