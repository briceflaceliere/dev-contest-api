<?php

namespace DevContest\DevContestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class LanguageController
 * @package DevContest\DevContestApiBundle\Controller
 */
class LanguageController extends AbstractController
{
    /**
     * Get Languages
     *
     * @param Request               $request
     * @param ParamFetcher          $paramFetcher
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     *
     * @ApiDoc(
     *   resource = "Languages",
     *   statusCodes = {
     *     200 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   output  = "Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination"
     * )
     *
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Page of the result")
     * @Rest\QueryParam(name="limit", requirements="([0-9]{1,2}|100)", default="25", description="Limit of the result")
     *
     * @Rest\View(serializerGroups={"all", "list"})
     */
    public function getLanguagesAction(Request $request, ParamFetcher $paramFetcher)
    {
        return parent::getObjects('DevContestApiBundle:Language', $request, $paramFetcher);
    }

    /**
     * Get Language
     *
     * @param integer $id       Id of the Language
     * @param Request $request
     * @return \DevContest\DevContestApiBundle\Entity\Language
     *
     * @ApiDoc(
     *   resource = "Languages",
     *   statusCodes = {
     *     200 = "Success",
     *     403 = "Insufficient access rights",
     *     404 = "Language not found"
     *   },
     *   output  = "DevContest\DevContestApiBundle\Entity\Language"
     * )
     *
     * @Rest\View(serializerGroups={"all", "detail"})
     * @Rest\Route(requirements={"id"="[0-9]+"})
     */
    public function getLanguageAction(int $id, Request $request)
    {
        return parent::getObject('DevContestApiBundle:Language', $request);
    }

    /**
     * Create Language
     *
     * @param Request $request
     * @return array
     *
     * @ApiDoc(
     *   resource = "Languages",
     *   statusCodes = {
     *     201 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\LanguageType"
     * )
     *
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function postLanguagesAction(Request $request)
    {
        return parent::postObjects('DevContestApiBundle:Language', $request);
    }

    /**
     * Update Language
     *
     * @param Request $request
     * @param integer $id      Id of the Language
     * @return array
     *
     * @ApiDoc(
     *   resource = "Languages",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\LanguageType"
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function putLanguagesAction(int $id, Request $request)
    {
        return parent::putObjects('DevContestApiBundle:Language', $request);
    }

    /**
     * Delete Language
     *
     * @param Request $request
     * @param integer $id      Id of the Language
     * @return array
     *
     * @ApiDoc(
     *   resource = "Languages",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   }
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteLanguagesAction(int $id, Request $request)
    {
        return parent::deleteObjects('DevContestApiBundle:Language', $request);
    }
}
