<?php

namespace Patgod85\Phpdoc2rst\Command;

use Patgod85\Phpdoc2rst\Command\Process\Controllers\ProcessController;
use Symfony\Component\Console\Question\Question;
use TokenReflection\Broker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \InvalidArgumentException;

class Process extends Command
{
    /**
     * @see Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $definition = new InputDefinition();
        $definition->addArgument(new InputArgument('namespace', InputArgument::REQUIRED, 'The namespace to process'));
        $definition->addArgument(new InputArgument('path', InputArgument::REQUIRED, 'The path the namespace can be found in'));
        $definition->addOption(new InputOption('output', 'o', InputOption::VALUE_REQUIRED, 'The path to output the ReST files', 'build'));
        $definition->addOption(new InputOption('title', 't', InputOption::VALUE_REQUIRED, 'An alternate title for the top level namespace', null));
        $definition->addOption(new InputOption('exclude', 'x', InputOption::VALUE_REQUIRED, 'Semicolon separated namespaces to ignore', null));

        $definition->addOption(new InputOption('elements', 'e', InputOption::VALUE_REQUIRED, 'Which elements need to select', 'properties'));

        $this
            ->setName('process')
            ->setDescription('Processes a directory of PHPDoc documented code into ReST')
            ->setHelp('The process command works recursively on a directory of PHP code.')
            ->setDefinition($definition);
    }

    /**
     * @see Symfony\Component\Console\Command.Command::interact()
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        if (!$input->getArgument('namespace'))
        {

            $question = new Question('<question>Namespace of code to document: </question> ');
            $question->setValidator(function ($namespace) {
                $namespace = trim($namespace);

                if (!$namespace) {
                    throw new InvalidArgumentException('Invalid namespace');
                }

                return $namespace;
            });
            $question->setHidden(false);
            $question->setMaxAttempts(5);

            $n = $helper->ask($input, $output, $question);

            $input->setArgument('namespace', $n);
        }

        $path = $input->getArgument('path');

        if (!$path || !is_readable($path))
        {
            $question = new Question('<question>Path to namespace: </question> ');
            $question->setValidator(function ($path) {
                $path = trim($path);

                if (!$path || !is_readable($path) || !is_dir($path)) {
                    throw new InvalidArgumentException('Invalid path to namespace source');
                }

                return $path;
            });
            $question->setHidden(false);
            $question->setMaxAttempts(5);

            $p = $helper->ask($input, $output, $question);
            $input->setArgument('path', $p);
        }

        $out = $input->getOption('output');

        if (!file_exists($out)) {
            mkdir($out, 0777, true);
        }

        if (!is_writable($out)) {
            $question = new Question('<question>Path to output built files: </question> [<comment>');
            $question->setValidator(function ($out) {
                 $out = trim($out);

                 if (!$out || !is_writable($out)) {
                     throw new \InvalidArgumentException('Invalid output path');
                 }
            });

            $question->setHidden(false);
            $question->setMaxAttempts(5);

            $helper->ask($input, $output, $question);
        }

        $elements = $input->getOption('elements');

        if(!in_array($elements, ['properties', 'methods', 'exceptions']))
        {
            throw new \InvalidArgumentException('Invalid elements option');
        }
    }

    /**
     * @see Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        new ProcessController($input, $output);
        return 1;
    }
}