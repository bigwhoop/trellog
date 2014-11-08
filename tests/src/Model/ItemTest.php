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

use Bigwhoop\Trellog\Model\Item;
use Bigwhoop\Trellog\Model\Author;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testProperties()
    {
        $author = new Author();
        
        $i = new Item();
        $i->description = 'some description';
        $i->author = $author;
        
        $this->assertSame('some description', $i->description);
        $this->assertSame($author, $i->author);
    }
}
