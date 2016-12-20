<?php

namespace Patgod85\Phpdoc2rst\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \InvalidArgumentException;

class AllCommand extends ContainerAwareCommand
{
    private $tasks;

    /**
     * @see \Symfony\Component\Console\Command.Command::configure()
     */
    protected function configure()
    {
        $this
            ->setName('phpdoc2rst:all')
            ->setDescription('The command runs phpdoc2rst:process for all tasks from config.yml')
            ->setHelp('Tasks should be described in config.yml')
            ->setDefinition([
                new InputOption('task', '', InputOption::VALUE_OPTIONAL, 'Run only specified task'),
            ]);
    }

    /**
     * @see \Symfony\Component\Console\Command.Command::interact()
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getContainer()->getParameter('patgod85_phpdoc2rst.tasks');

        $tasks = [];

        foreach($config as $taskName => $task)
        {
            if(!$input->getOption('task') || $input->getOption('task') == $taskName)
            {
                foreach($task['subtasks'] as $subtaskName => $subtask)
                {
                    $tasks[$taskName.':'.$subtaskName] = $subtask;
                }
            }
        }

        if(!count($tasks))
        {
            throw new InvalidArgumentException('No tasks found in config.yml for specified condition');
        }

        $this->tasks = $tasks;
    }

    /**
     * @see \Symfony\Component\Console\Command.Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach($this->tasks as $taskName => $taskParams)
        {
            echo 'Running of task: '.$taskName."\n";

            $command = $this->getApplication()->find('phpdoc2rst:process');
            $arguments = [
                'namespace' => $taskParams['namespace'],
                'path' => $taskParams['input'],
                '-o' => $taskParams['output'],
            ];

            if(isset($taskParams['target']))
            {
                $arguments['--target'] = $taskParams['target'];
            }

            if(isset($taskParams['exclude']))
            {
                $arguments['-x'] = $taskParams['exclude'];
            }

            $input = new ArrayInput($arguments);
            $returnCode = $command->run($input, $output);

            echo "Done with code: $returnCode\n";
        }
    }
}