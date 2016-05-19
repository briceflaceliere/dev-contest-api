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
 * Add role for user
 */
class RoleAddCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('devcontest:role:add')
            ->setDescription('Add role for user')
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'The user email'
            )
            ->addArgument(
                'role',
                InputArgument::REQUIRED,
                'Role to add'
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
            $user->addRole($role);
            $entityManager->persist($user);
            $entityManager->flush();
        } else {
            throw new \Exception(sprintf('User %s not found', $email));
        }

    }

}
