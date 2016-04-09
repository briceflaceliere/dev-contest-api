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
 *
 * Generate basic files for an Entity :
 * - Controller
 * - TestController
 * - DatFixture
 * - FormType
 * - Repository
 *
 * Add  basic route into the Resources/Config/routing.yml file
 *
 */
class GenerateControllerCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('devcontest:generate:controller')
            ->setDescription('Generate basic controller and tests files from an entity')
            ->addArgument(
                'entity',
                InputArgument::REQUIRED,
                'The entity to generate'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entity = $input->getArgument('entity');
        $entityManager = $this->getContainer()->get('doctrine')->getManager();


        if ($entityManager->getClassMetadata($entity)) {
            $entityName = end(explode('\\', $entityManager->getClassMetadata($entity)->getName()));
            $bundleName = explode('\\', $entityManager->getClassMetadata($entity)->getName())[1];

            // Ask for the plural of the EntityName
            $helper   = $this->getHelper('question');
            $question = new Question('Please enter the plural of the entity : (<info>'.$entityName.'s</>)', $entityName.'s');
            $plural = $helper->ask($input, $output, $question);

            // Create files

            $filesToCreate = [
                'Controller' => [
                    'defaultFile' => __DIR__.'/GenerateControllerCommandFiles/_DefaultEntityController',
                    'fileName' => $entityName.'Controller',
                    'filePath' => __DIR__.'/../Controller/'.$entityName.'Controller.php',
                ],

                'Test controller' => [
                    'defaultFile' => __DIR__.'/GenerateControllerCommandFiles/_DefaultEntityTest',
                    'fileName' => $entityName.'ControllerTest',
                    'filePath' => __DIR__.'/../Tests/Controller/'.$entityName.'ControllerTest.php',
                ],

                'Data Fixtures' => [
                    'defaultFile' => __DIR__.'/GenerateControllerCommandFiles/_DefaultEntityFixtures',
                    'fileName' => 'Load'.$entityName.'Data',
                    'filePath' => __DIR__.'/../DataFixtures/ORM/Load'.$entityName.'Data.php',
                ],

                'Repository' => [
                    'defaultFile' => __DIR__.'/GenerateControllerCommandFiles/_DefaultEntityRepository',
                    'fileName' => $entityName.'Repository',
                    'filePath' => __DIR__.'/../Repository/'.$entityName.'Repository.php',
                ],

                'Form type' => [
                    'defaultFile' => __DIR__.'/GenerateControllerCommandFiles/_DefaultEntityFormType',
                    'fileName' => $entityName.'Type',
                    'filePath' => __DIR__.'/../Form/Type/'.$entityName.'Type.php',
                ],
            ];

            foreach ($filesToCreate as $file => $options) {
                $defaultFile = $options['defaultFile'];
                $fileName    = $options['fileName'];
                $filePath    = $options['filePath'];

                $output->writeLn('');

                if (file_exists($filePath)) {
                    $question = new ConfirmationQuestion('<comment>'.$file.'</> file '.$fileName.' already exists. <error>Overwrite</> ? (<info>true</>)', true);
                } else {
                    $question = new ConfirmationQuestion('Create <comment>'.$file.'</> file '.$fileName.' ? (<info>true</>)', true);
                }

                if ($helper->ask($input, $output, $question)) {
                    exec('cp '.$defaultFile.' '.$filePath);
                    $this->replaceEntityInTemplates($filePath, $entityName, $plural, $bundleName);

                    $output->writeLn($fileName.' created.');
                }
            }

            // Add routes
            $routing = [
                'defaultFile' => __DIR__.'/GenerateControllerCommandFiles/_DefaultEntityRouting',
                'filePath' => __DIR__.'/../Resources/config/routing.yml',
            ];

            $defaultFile = $routing['defaultFile'];
            $filePath    = $routing['filePath'];

            if (strpos(file_get_contents($filePath), 'dev_contest.api.'.strtolower($entityName)) !== false) {
                $output->writeLn('');
                $output->writeLn('<comment>Routes</> already exists. (well.. check it a bit ;))');
            } else {
                $question = new ConfirmationQuestion('Add <comment>routes</> ? (<info>true</>)', true);

                $output->writeLn('');
                if ($helper->ask($input, $output, $question)) {
                    exec('cat '.$defaultFile.' >>'.$filePath);
                    $this->replaceEntityInTemplates($filePath, $entityName, $plural, $bundleName);

                    $output->writeLn('Routes added.');
                }
            }
        }
    }

    /**
     * Replace entity in the templates
     *
     * @param string $filePath
     * @param string $entityName
     * @param string $plural
     * @param string $bundleName
     */
    protected function replaceEntityInTemplates($filePath, $entityName, $plural, $bundleName)
    {
        exec('sed -i "s/{{Entity}}/'.$entityName.'/g" '.$filePath);
        exec('sed -i "s/{{Entities}}/'.$plural.'/g" '.$filePath);
        exec('sed -i "s/{{Bundle}}/'.$bundleName.'/g" '.$filePath);
        exec('sed -i "s/{{entity}}/'.strtolower($entityName).'/g" '.$filePath);
        exec('sed -i "s/{{entities}}/'.strtolower($plural).'/g" '.$filePath);
    }
}
