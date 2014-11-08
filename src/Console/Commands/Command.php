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
use Phine\Path\Path;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

abstract class Command extends BaseCommand
{
    /**
     * @param InputInterface $input
     * @return string
     */
    protected function getConfigPath(InputInterface $input)
    {
        $configPath = $input->getOption('config');
        if (empty($configPath)) {
            $configPath = '.trellog.yml';
        }
        if (!Path::isAbsolute($configPath)) {
            $configPath = getcwd() . "/$configPath";
        }
        
        return Path::canonical($configPath);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return TrellogConfig
     */
    protected function getConfig(InputInterface $input, OutputInterface $output)
    {
        $configPath = $this->getConfigPath($input);
        
        if (!file_exists($configPath)) {
            $output->writeln(sprintf("<error>Config file '%s' does not exist.</error>", $configPath));
            $output->writeln('You can create a default config file by running the init command.');
            $this->halt(1);
        }
        
        return TrellogConfig::load($configPath);
    }

    /**
     * @param int $exitCode
     */
    protected function halt($exitCode = 0)
    {
        exit($exitCode);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param string $question
     * @param callable $validation
     * @return string
     */
    protected function askQuestion(InputInterface $input, OutputInterface $output, $question, callable $validation)
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');
        
        $question = new Question("  $question ");
        $question->setValidator($validation);
        return $questionHelper->ask($input, $output, $question);
    }

    /**
     * Presents $choices using numeric indexes, but returns the actual key of the selected element.
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param array $choices
     * @return string
     */
    protected function presentSelection(InputInterface $input, OutputInterface $output, array $choices)
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');
        
        $indexedChoices = array_values($choices);
        
        $question = new ChoiceQuestion('', $indexedChoices);
        $question->setValidator(function($choice) use ($indexedChoices, $choices) {
            if (!array_key_exists($choice, $indexedChoices)) {
                $max = count($indexedChoices) - 1;
                throw new \Exception("Option must be between 0 and $max.");
            }
            return array_search($indexedChoices[$choice], $choices);
        });
        return $questionHelper->ask($input, $output, $question);
    }
}
