<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Trello;

class URLs
{
    /**
     * @return string
     */
    public static function getGenerateKeyURL()
    {
        return 'https://trello.com/1/appKey/generate';
    }

    /**
     * @param string $apiKey
     * @return string
     */
    public static function getAuthorizationURL($apiKey)
    {
        $app = Config::APP_NAME;
        return "https://trello.com/1/authorize?response_type=token&scope=read&expiration=never&name={$app}&key=$apiKey";
    }
}
