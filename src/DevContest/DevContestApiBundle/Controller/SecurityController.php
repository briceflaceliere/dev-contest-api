<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 11/04/16
 * Time: 18:46
 */

namespace DevContest\DevContestApiBundle\Controller;


use DevContest\DevContestApiBundle\Form\Type\OauthLoginType;
use DevContest\DevContestApiBundle\Security\OauthLogin;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


class SecurityController extends AbstractController
{
    /**
     * Get token for user
     *
     * @param Request $request
     * @return array
     *
     * @ApiDoc(
     *   resource = "Token",
     *   statusCodes = {
     *     201 = "Success",
     *     403 = "Insufficient access rights"
     *   },
     *   input   = "DevContest\DevContestApiBundle\Form\Type\OauthLoginType"
     * )
     *
     * @Rest\View()
     * @Rest\Post("/token/user")
     */
    public function postLoginUserAction(Request $request)
    {
        $oauthLogin = new OauthLogin();
        $form = $this->createForm(new OauthLoginType(), $oauthLogin);

        $form->submit($request);
        if ($form->isValid()) {
            var_dump($oauthLogin);exit();

            return $this->view(
                null,
                Codes::HTTP_NO_CONTENT
            );
        }

        return [
            'form' => $form,
        ];
    }



}