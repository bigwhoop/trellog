<?php
/**
 * This file is part of trellog.
 *
 * (c) Philippe Gerber
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bigwhoop\Trellog\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class App extends Application
{
    /**
     * {@inheritdoc}
     */
    public function __construct($name = 'trellog', $version = '1.0.2')
    {
        parent::__construct($name, $version);
        $this->setCatchExceptions(true);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configureIO(InputInterface $input, OutputInterface $output)
    {
        parent::configureIO($input, $output);
        
        $formatter = $output->getFormatter();
        $formatter->setStyle('warning', new OutputFormatterStyle('white', 'blue', ['bold']));
        $formatter->setStyle('url', new OutputFormatterStyle('blue'));
        $formatter->setStyle('bold', new OutputFormatterStyle(null, null, ['bold']));
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new Commands\Init();
        $commands[] = new Commands\Generate();
        
        return $commands;
    }
    
    /**
     * {@inheritDoc}
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption(new InputOption('--config', '-c', InputOption::VALUE_REQUIRED,
            'The path to the .trellog.yml file. Defaults to .trellog.yml in the current working directory.'
        ));
        
        return $definition;
    }
}
