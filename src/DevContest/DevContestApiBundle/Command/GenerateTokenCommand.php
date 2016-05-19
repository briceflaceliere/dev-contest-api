<?php

namespace DevContest\DevContestApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Generate api token for user
 */
class GenerateTokenCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('devcontest:generate:token')
            ->setDescription('Generate token for user')
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'The user email'
            )
            ->addOption(
                'ttl',
                null,
                InputOption::VALUE_OPTIONAL,
                'Time to live for token in second (default: 36000)',
                36000
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $entityManager = $this->getContainer()->get('doctrine')->getManager();
        $userRepository = $entityManager->getRepository('DevContestApiBundle:User');

        if ($user = $userRepository->findOneByEmail($email)) {
            $token = $this->getContainer()->get('jwt_auth.auth0_service')->encodeJWT($user->getJwtPayload(), $input->getOption('ttl'));
            $output->writeln('Token:');
            $output->writeln($token);
        } else {
            throw new \Exception(sprintf('User % not found', $email));
        }

    }

}
