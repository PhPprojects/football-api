<?php

namespace Knp\ChallengeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FetchCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fetch:data')
            ->setDescription('That fetches data from Soccerway Premier League')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $helper = $this->getContainer()->get('challenge.import_soccer_way');

        if ($helper->fetchData()) {
            $output->writeln('Fetch data success!');
        }
        else {
            $output->writeln('Something went wrong :(');
        }

    }
}