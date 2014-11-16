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

class TrellogConfig extends Config
{
    /** @var AuthConfig */
    public $auth;
    
    /** @var SourceConfig */
    public $source;
    
    /** @var MapperConfig */
    public $mapper;
    
    /** @var PrinterConfig */
    public $printer;
    
    public function __construct()
    {
        $this->auth    = new AuthConfig();
        $this->source  = new SourceConfig();
        $this->mapper  = new MapperConfig();
        $this->printer = new PrinterConfig();
    }
}
