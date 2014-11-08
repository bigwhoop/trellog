<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\TestAssets\Fixtures;

use Bigwhoop\Trellog\Model\Author;

class AuthorFixture extends Author
{
    public function __construct()
    {
        $this->name = 'Phil';
    }
}
