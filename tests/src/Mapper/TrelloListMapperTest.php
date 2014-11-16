<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Tests\Mapper;

use Bigwhoop\Trellog\Exception;
use Bigwhoop\Trellog\Mapper\TrelloListMapper;
use Bigwhoop\Trellog\Model\Entry;
use Bigwhoop\Trellog\Model\Section;
use Bigwhoop\Trellog\Model\Item;
use Trello\Model\Card;

class TrelloListMapperTest extends \PHPUnit_Framework_TestCase
{
    /** @var TrelloListMapper */
    private $factory;
    
    protected function setUp()
    {
        $this->factory = new TrelloListMapper();
    }

    /**
     * @return array
     */
    public function invalidSectionDefinitions()
    {
        return [
            [[]],
            [['foo' => 'bar']],
            [['name' => 'foo']],
            [['checkItems' => 'foo']],
        ];
    }

    /**
     * @return array
     */
    public function invalidItemDefinitions()
    {
        return [
            [[]],
            [['foo' => 'bar']],
            [['name']],
        ];
    }
    
    public function testCreateEntry()
    {
        $card = $this->createCard(
            '1.2.3',
            '2014-12-03',
            [
                ['name' => 'section 1', 'checkItems' => []],
                ['name' => 'section 2', 'checkItems' => []],
            ]
        );
        
        $entry = $this->factory->createEntry($card);
        
        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertSame('1.2.3', $entry->version);
        $this->assertEquals(new \DateTime('2014-12-03'), $entry->date);
        $this->assertCount(2, $entry->getSections());
        $this->assertInstanceOf(Section::class, $entry->getSections()[0]);
        $this->assertSame('section 1', $entry->getSections()[0]->name);
        $this->assertInstanceOf(Section::class, $entry->getSections()[1]);
        $this->assertSame('section 2', $entry->getSections()[1]->name);
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

    /**
     * @param array $data
     * @dataProvider invalidSectionDefinitions
     * @expectedException Exception
     * @expectedExceptionMessage First argument must be an array having the following keys: name, checkItems
     */
    public function testCreateSectionWithInvalidData(array $data)
    {
        $this->factory->createSection($data);
    }
    
    public function testCreateItem()
    {
        $item = $this->factory->createItem(['name' => 'Fixed the problem.']);
        
        $this->assertInstanceOf(Item::class, $item);
        $this->assertSame('Fixed the problem.', $item->description);
    }

    /**
     * @param array $data
     * @dataProvider invalidItemDefinitions
     * @expectedException Exception
     * @expectedExceptionMessage First argument must be an array having the following keys: name
     */
    public function testCreateItemWithInvalidData(array $data)
    {
        $this->factory->createSection($data);
    }

    /**
     * @param string $name
     * @param string $date
     * @param array $checklists
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createCard($name, $date, array $checklists)
    {
        $card = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $card->expects($this->any())
            ->method('__get')
            ->will($this->returnCallback(function($key) use ($name, $date, $checklists) {
                switch ($key) {
                    case 'name': return $name;
                    case 'due': return $date;
                    case 'checklists': return $checklists;
                }
                throw new \LogicException("Can't test this property: $key");
            }));
        
        return $card;
    }
}
