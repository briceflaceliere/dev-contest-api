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
 * Remove role for user
 */
class RoleRmCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('devcontest:role:rm')
            ->setDescription('Remove role for user')
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'The user email'
            )
            ->addArgument(
                'role',
                InputArgument::REQUIRED,
                'Role to remove'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $role = $input->getArgument('role');
        $entityManager = $this->getContainer()->get('doctrine')->getManager();
        $userRepository = $entityManager->getRepository('DevContestApiBundle:User');

        if ($user = $userRepository->findOneByEmail($email)) {
            $user->removeRole($role);
            $entityManager->persist($user);
            $entityManager->flush();
        } else {
            throw new \Exception(sprintf('User %s not found', $email));
        }
    }
}
