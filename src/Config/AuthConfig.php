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

class AuthConfig extends Config
{
    /** @var string */
    public $apiKey = '';
    
    /** @var string */
    public $accessToken = '';
}
