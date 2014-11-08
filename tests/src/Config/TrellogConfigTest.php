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

use Bigwhoop\Trellog\Config\TrellogConfig;
use Bigwhoop\Trellog\Config\AuthConfig;
use Bigwhoop\Trellog\Config\SourceConfig;
use Bigwhoop\Trellog\Config\PrinterConfig;

class TrellogConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultConfig()
    {
        $config = new TrellogConfig();
        
        $this->assertInstanceOf(AuthConfig::class, $config->auth);
        $this->assertInstanceOf(SourceConfig::class, $config->source);
        $this->assertInstanceOf(PrinterConfig::class, $config->printer);
    }
    
    public function testToArray()
    {
        $config = new TrellogConfig();
        $config->auth->apiKey = 'my-api-key';
        $config->auth->accessToken = 'my-access-token';
        $config->source->boardId = 'my-board-id';
        $config->source->listId = 'my-list-id';
        $config->printer->class = 'my-printer-class';
        $config->printer->options = ['my-printer-option-1' => 'foo', 'my-printer-option-2' => 'bar'];
        
        $this->assertSame([
            'auth' => [
                'apiKey' => 'my-api-key',
                'accessToken' => 'my-access-token',
            ],
                'source' => [
                'listId' => 'my-list-id',
                'boardId' => 'my-board-id',
            ],
            'printer' => [
                'class' => 'my-printer-class',
                'options' => [
                    'my-printer-option-1' => 'foo',
                    'my-printer-option-2' => 'bar',
                ],
            ],
        ], $config->toArray());
    }
    
    public function testFromArray()
    {
        $config = new TrellogConfig();
        $config->fromArray([
            'auth' => [
                'apiKey' => 'my-api-key',
                'accessToken' => 'my-access-token',
            ],
                'source' => [
                'listId' => 'my-list-id',
                'boardId' => 'my-board-id',
            ],
            'printer' => [
                'class' => 'my-printer-class',
                'options' => [
                    'my-printer-option-1' => 'foo',
                    'my-printer-option-2' => 'bar',
                ],
            ],
        ]);
        
        $this->assertSame('my-api-key', $config->auth->apiKey);
        $this->assertSame('my-access-token', $config->auth->accessToken);
        $this->assertSame('my-board-id', $config->source->boardId);
        $this->assertSame('my-list-id', $config->source->listId);
        $this->assertSame('my-printer-class', $config->printer->class);
        $this->assertSame(['my-printer-option-1' => 'foo', 'my-printer-option-2' => 'bar'], $config->printer->options);
    }
}
