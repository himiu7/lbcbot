<?php

namespace App\Command;

use App\Document\Task;
use App\Service\TaskManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LbcTaskCommand extends ContainerAwareCommand
{
    /**
     * @var TaskManager
     */
    protected $tm;

    protected static $defaultName = 'lbc:task';

    public function __construct(TaskManager $tm)
    {
        $this->tm = $tm;

        // this is required due to parent constructor, which sets up name
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        /** @var Task $task */
        $task = $this->tm->startTask();

        $command = $this->getApplication()->find($task);

        $arguments = array(
            'command' => 'demo:greet',
            'name'    => 'Fabien',
            '--yell'  => true,
        );

        $greetInput = new ArrayInput($arguments);
        $returnCode = $command->run($greetInput, $output);

        $tm->
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
