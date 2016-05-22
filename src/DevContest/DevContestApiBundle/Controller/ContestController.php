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
 * Class ContestController
 * @package DevContest\DevContestApiBundle\Controller
 */
class ContestController extends AbstractController
{
    /**
     * Get Contests
     *
     * @param Request               $request
     * @param ParamFetcherInterface $paramFetcher
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     *
     * @ApiDoc(
     *   resource = "Contests",
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
    public function getContestsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        return parent::getObjects('DevContestApiBundle:Contest', $request, $paramFetcher);
    }

    /**
     * Get Contest
     *
     * @param integer $id Id of the Contest
     * @return \DevContest\DevContestApiBundle\Entity\Contest
     *
     * @ApiDoc(
     *   resource = "Contests",
     *   statusCodes = {
     *     200 = "Success",
     *     403 = "Insufficient access rights",
     *     404 = "Contest not found"
     *   },
     *   output  = "DevContest\DevContestApiBundle\Entity\Contest"
     * )
     *
     * @Rest\View(serializerGroups={"all", "detail"})
     * @Rest\Route(requirements={"id"="[0-9]+"})
     */
    public function getContestAction($id)
    {
        return parent::getObject('DevContestApiBundle:Contest', $id);
    }

    /**
     * Create Contest
     *
     * @param Request $request
     * @return array
     *
     * @ApiDoc(
     *   resource = "Contests",
     *   statusCodes = {
     *     201 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\ContestType"
     * )
     *
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function postContestsAction(Request $request)
    {
        return parent::postObjects('DevContestApiBundle:Contest', $request);
    }

    /**
     * Update Contest
     *
     * @param Request $request
     * @param integer $id      Id of the Contest
     * @return array
     *
     * @ApiDoc(
     *   resource = "Contests",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\ContestType"
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function putContestsAction(Request $request, $id)
    {
        return parent::putObjects('DevContestApiBundle:Contest', $request, $id);
    }

    /**
     * Delete Contest
     *
     * @param Request $request
     * @param integer $id      Id of the Contest
     * @return array
     *
     * @ApiDoc(
     *   resource = "Contests",
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
    public function deleteContestsAction(Request $request, $id)
    {
        return parent::deleteObjects('DevContestApiBundle:Contest', $request, $id);
    }
}
