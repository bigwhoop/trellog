<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Console\Commands;

use Bigwhoop\Trellog\Config\TrellogConfig;
use Bigwhoop\Trellog\Trello\Client;
use Bigwhoop\Trellog\Trello\URLs as TrelloURLs;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Init extends Command
{
    protected function configure()
    {
        $this->setName('init')
             ->setDescription('Initialize trellog and create a .trellog.yml configuration file.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $this->getConfigPath($input);
        
        $existsNote = file_exists($configFile) ? "\n<warning>The existing file will be overwritten.</warning>" : '';
        
        $output->writeln(<<<TXT
Welcome to <info>trellog</info>.

This wizard will help you configure a trellog configuration file.
The file will be created at <info>$configFile</info>.$existsNote

You can change the path using the <info>--config</info> option.

TXT
        );
        
        $config = new TrellogConfig();
        
        // Grab API key
        $output->writeln("1) <info>First you need to grap your trello.com API key. Please visit the following URL and copy the <bold>Key</bold> at the top.</info>\n");
        $output->writeln("  <url>" . TrelloURLs::getGenerateKeyURL() . "</url>");
        $config->auth->apiKey = $this->askQuestion($input, $output, 'API Key:', function($apiKey) {
            if (strlen($apiKey) !== 32) {
                throw new \Exception('The entered key seems to be invalid.');
            }
            return $apiKey;
        });
        $output->writeln('');
        
        // Grab access token
        $output->writeln("2) <info>Next you need to authenticate trellog with trello.com. Please visit the following URL, authorize trellog and copy the <bold>Access Token</bold> that is presented to you.</info>\n");
        $output->writeln("  <url>" . TrelloURLs::getAuthorizationURL($config->auth->apiKey) . "</url>");
        $config->auth->accessToken = $this->askQuestion($input, $output, 'Access Token:', function($token) {
            if (strlen($token) !== 64) {
                throw new \Exception('The entered access token seems to be invalid.');
            }
            return $token;
        });
        $output->writeln('');
        
        $trello = new Client($config->auth->apiKey, $config->auth->accessToken);
        
        // Grab board ID
        $boards = $trello->getMyBoardsAsArray();
        $output->writeln("3) <info>Please select the board that contains the CHANGELOG list:</info>");
        $config->source->boardId = $this->presentSelection($input, $output, $boards);
        $output->writeln('');
        
        // Grab list
        $lists = $trello->getListsForBoardAsArray($config->source->boardId);
        $output->writeln("4) <info>Finally select the list that represents the CHANGELOG:</info>");
        $config->source->listId = $this->presentSelection($input, $output, $lists);
        $output->writeln('');
        
        $config->save($configFile);
        
        $output->writeln("Successfully wrote configuration to <info>$configFile</info>.");
        $output->writeln("Use <info>trellog generate > CHANGELOG.md</info> to generate your first CHANGELOG.");
    }
}
