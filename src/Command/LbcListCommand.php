<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LbcListCommand extends LbcTaskCommand
{
    protected static $defaultName = 'lbc:list';

    protected function configure()
    {
        $this
            ->setDescription('Updates Market`s and User`s Ads')
            ->addArgument('type', InputArgument::REQUIRED, 'List type: `sell`|`user`|`buy`')
            ->addArgument('filter', InputArgument::OPTIONAL, "Country code [cc:`ru`,`ua`, ...']\nCurrency [cur:`usd`, `uah`, ...']")
            ->addOption('secs', 's', InputOption::VALUE_REQUIRED, 'Delay in seconds after last update')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $type = $input->getArgument('type');

        if (!$type) {
            $io->note(sprintf('You passed an argument: %s', $type));
        }

        $secs = $input->getOption('secs') ?? 15;

        dump([$type, $secs]);

        $io->success('Ok');
    }
}
