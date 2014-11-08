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

use Bigwhoop\Trellog\Model\Author;

class AuthorTest extends \PHPUnit_Framework_TestCase
{
    public function testProperties()
    {
        $author = new Author();
        $author->name = 'foo';
        
        $this->assertSame('foo', $author->name);
    }
}
