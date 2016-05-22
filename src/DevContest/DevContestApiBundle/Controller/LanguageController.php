<?php

namespace DevContest\DevContestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
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
     * @param ParamFetcherInterface $paramFetcher
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
    public function getLanguagesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return parent::getObjects('DevContestApiBundle:Language', $request, $paramFetcher);
    }

    /**
     * Get Language
     *
     * @param integer $id Id of the Language
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
    public function getLanguageAction($id)
    {
        return parent::getObject('DevContestApiBundle:Language', $id);
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
    public function putLanguagesAction(Request $request, $id)
    {
        return parent::putObjects('DevContestApiBundle:Language', $request, $id);
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
    public function deleteLanguagesAction(Request $request, $id)
    {
        return parent::deleteObjects('DevContestApiBundle:Language', $request, $id);
    }
}
