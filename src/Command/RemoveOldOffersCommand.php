<?php

namespace App\Command;

use App\Entity\JobOffer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RemoveOldOffersCommand extends Command
{
    protected static $defaultName = 'app:remove-old-offers';

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(string $name = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);
        $this->em = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('This command removes old offers')
            ->addArgument('max-days', InputArgument::OPTIONAL, 'Days to be consider an offer as old', 90)
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Apply changes or not')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $maxDays = $input->getArgument('max-days');

        $io->note(sprintf('Offers older than %s are considered old', $maxDays));

        $dryRun = false;
        if ($input->getOption('dry-run')) {
            $dryRun = true;

            $io->note('No changes will happend');
        }

        $oldOffers = $this->em->getRepository(JobOffer::class)
            ->createQueryBuilder('jo')
            ->where('jo.created_at < :limitDate')
            ->setParameter('limitDate', new DateTimeImmutable('today - ' . $maxDays . ' days'))
            ->getQuery()
            ->getResult();

        $io->writeln('There are ' . count($oldOffers) . ' old offers');

        foreach ($oldOffers as $oldOffer) {
            $this->em->remove($oldOffer);
        }

        $io->success('All old offers have been removed');

        return 0;
    }
}
