<?php

namespace DevContest\DevContestApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ContestStepController
 * @package DevContest\DevContestApiBundle\Controller
 */
class ContestStepController extends AbstractController
{
    /**
     * Get ContestSteps
     *
     * @param integer               $contest  Id of contest
     * @param Request               $request
     * @param ParamFetcher          $paramFetcher
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
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
     * @Rest\Route(requirements={"contest"="[0-9]+"})
     */
    public function getStepsAction(int $contest, Request $request, ParamFetcher $paramFetcher)
    {
        return parent::getObjects('DevContestApiBundle:ContestStep', $request, $paramFetcher);
    }

    /**
     * Get ContestStep
     *
     * @param integer $contest  Id of contest
     * @param integer $id       Id of contestStep
     * @param Request $request
     * @return \DevContest\DevContestApiBundle\Entity\ContestStep
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
     *   statusCodes = {
     *     200 = "Success",
     *     403 = "Insufficient access rights",
     *     404 = "ContestStep not found"
     *   },
     *   output  = "DevContest\DevContestApiBundle\Entity\ContestStep"
     * )
     *
     * @Rest\View(serializerGroups={"all", "detail"})
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\Route(requirements={"contest"="[0-9]+"})
     */
    public function getStepAction(int $contest, int $id, Request $request)
    {
        return parent::getObject('DevContestApiBundle:ContestStep', $request);
    }

    /**
     * Create ContestStep
     *
     * @param Request $request
     * @param integer $contest  Id of contest
     * @return array
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
     *   statusCodes = {
     *     201 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\ContestStepType"
     * )
     *
     * @Rest\View()
     * @Rest\Route(requirements={"contest"="[0-9]+"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function postStepsAction(int $contest, Request $request)
    {
        return parent::postObjects('DevContestApiBundle:ContestStep', $request);
    }

    /**
     * Update ContestStep
     *
     * @param Request $request
     * @param integer $contest  Id of contest
     * @param integer $id       Id of contestStep
     * @return array
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\ContestStepType"
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\Route(requirements={"contest"="[0-9]+"})
     */
    public function putStepsAction(int $contest, int $id, Request $request)
    {
        return parent::putObjects('DevContestApiBundle:ContestStep', $request);
    }

    /**
     * Delete ContestStep
     *
     * @param Request $request
     * @param integer $contest  Id of contest
     * @param integer $id       Id of contestStep
     * @return array
     *
     * @ApiDoc(
     *   resource = "Contests / Steps",
     *   statusCodes = {
     *     204 = "Success",
     *     403 = "Insufficient access rights"
     *   }
     * )
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\View()
     *
     * @Rest\Route(requirements={"id"="[0-9]+"})
     * @Rest\Route(requirements={"contest"="[0-9]+"})
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteStepsAction(int $contest, int $id, Request $request)
    {
        return parent::deleteObjects('DevContestApiBundle:ContestStep', $request);
    }
}
