<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Config;

use Bigwhoop\Trellog\Mapper\TrelloListMapper;

class MapperConfig extends Config
{
    /** @var string */
    public $class = '';
    
    /** @var array */
    public $options = [];
    
    public function __construct()
    {
        $this->class = TrelloListMapper::class;
    }
}
