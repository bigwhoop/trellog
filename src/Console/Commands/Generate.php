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

use Bigwhoop\Trellog\Model\ChangeLog;
use Bigwhoop\Trellog\Model\StandardModelFactory;
use Bigwhoop\Trellog\Printer\PrinterFactory;
use Bigwhoop\Trellog\Trello\Client;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Generate extends Command
{
    protected function configure()
    {
        $this->setName('generate')
             ->setDescription('Generate a CHANGELOG file based on a .trellog.yml file.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig($input, $output);
        
        $client = new Client($config->auth->apiKey, $config->auth->accessToken);
        $board = $client->getBoard($config->source->boardId);
        $lists = $board->getLists([
            'fields' => 'id,name',
        ]);
        
        $modelFactory = new StandardModelFactory();
        
        $changeLog = new ChangeLog();
        foreach ($lists as $list) {
            /** @var \Trello\Model\Lane $list */
            if ($list->id === $config->source->listId) {
                $changeLog = $modelFactory->createChangeLog($list);
                break;
            }
        }
        
        $printer = PrinterFactory::create($config->printer->class, $config->printer->options);
        $generatedLog = $printer->printChangeLog($changeLog);
        
        $output->write($generatedLog);
    }
}
