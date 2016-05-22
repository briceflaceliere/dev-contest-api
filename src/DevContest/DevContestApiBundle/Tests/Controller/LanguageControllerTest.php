<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;
use DevContest\DevContestApiBundle\Tests\SubTest\DeleteSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\GetSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\PaginatorSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\PostPutSubTest;

/**
 * Class tests the LanguageController
 * @package DevContest\DevContestApiBundle\Tests\Controller
 */
class LanguageControllerTest extends WebTestCase
{

    protected $loadFixtures = [
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadUserData',
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadLanguageData',
    ];

    /**
     * Test of getLanguagesAction method
     */
    public function testGetLanguagesAction()
    {
        $subTest = new PaginatorSubTest($this->getUrl('get_languages'));
        $subTest->setItemsNotEmpty(true);
        // $subTest->setItemKeys(['id', 'username']);
        $this->aclTest($subTest, [null, 'user1', 'api', 'engine', 'admin'], []);
    }

    /**
     * Test of getLanguageAction method
     */
    public function testGetLanguageAction()
    {
        $language1Id = $this->fixtures->getReference('languagePhp')->getId();

        $subTest = new GetSubTest($this->getUrl('get_language', ['id' => $language1Id]));
        $subTest->setItemKeys(['id', 'name', 'logo']);
        $this->aclTest($subTest, [null, 'user1', 'api', 'engine', 'admin'], []);
    }

    /**
     * Test of deleleLanguagesAction method
     */
    public function testDeleleLanguagesAction()
    {
        $language1Id = $this->fixtures->getReference('languagePhp')->getId();

        $subTest = new DeleteSubTest($this->getUrl('delete_languages', ['id' => $language1Id]));
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Test of post$LanguageAction method
     *
     * @param array $language
     * @dataProvider languageProvider
     */
    public function testPostLanguagesAction($language)
    {
        $subTest = new PostPutSubTest($this->getUrl('post_languages'), 'POST', ['language' => $language]);
        $subTest->addCheckValue('name', $language['name']);
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Test of put$LanguageAction method
     *
     * @param array $language
     * @dataProvider languageProvider
     */
    public function testPutLanguagesAction($language)
    {
        $language1Id = $this->fixtures->getReference('languagePhp')->getId();

        $subTest = new PostPutSubTest($this->getUrl('put_languages', ['id' => $language1Id]), 'PUT', ['language' => $language]);
        $subTest->addCheckValue('name', $language['name']);
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Language data provider
     * @return array
     */
    public function languageProvider()
    {
        return [
            [['name' => 'Python']]
        ];
    }
}
