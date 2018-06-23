<?php

namespace App\Command;

use App\Document\Task;
use App\Service\TaskManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LbcTaskException extends \Exception
{
}

class LbcTaskCommand extends ContainerAwareCommand
{
    /**
     * @var TaskManager
     */
    protected $tm;
    /**
     * @var DocumentManager
     */
    protected $dm;

    protected static $defaultName = 'lbc:task';

    public function __construct(TaskManager $tm, DocumentManager $dm)
    {
        $this->tm = $tm;
        $this->dm = $dm;
        // this is required due to parent constructor, which sets up name
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Executes Task commands')
            ->addArgument('redo', InputArgument::OPTIONAL, 'Interval to restart')
            ->addArgument('limit', InputArgument::OPTIONAL, 'Max execution time in seconds')
            ->addOption('list', null, InputOption::VALUE_NONE, 'Update tasks lists only')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $redo = $input->getArgument('redo');
        if ($redo) {
            $io->note(sprintf("Restart in: %d secs.", $redo));
        }

        $limit = $input->getArgument('limit');
        if ($limit) {
            $io->note(sprintf("End in %d secs.", $limit));
        }

        if ($input->getOption('list')) {
            // TODO start only Lists
        }


        $now = new \MongoTimestamp(time() - 15);
        $qb = $this->dm->createQueryBuilder(Task::class);

        $res = $qb
            ->addOr($qb->expr()->field('status')->equals(Task::STATUS_NEW))
            ->addOr($qb->expr()
                ->addAnd($qb->expr()->field('status')->equals(Task::STATUS_ACTIVE))
                ->addAnd($qb->expr()->field('next_start')->lt($now))
            )
            ->getQuery()
            ->execute();

        dump($res);
        die;

        /*$command = $this->getApplication()->find($task);

        $arguments = array(
            'command' => 'demo:greet',
            'name'    => 'Fabien',
            '--yell'  => true,
        );

        $greetInput = new ArrayInput($arguments);
        $returnCode = $command->run($greetInput, $output);

        $tm->*/
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
