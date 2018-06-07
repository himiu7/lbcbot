<?php

namespace App\Controller;

use App\Form\PayPbType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Api\PbBundle\ApiClient;
use App\Api\PbBundle\Model\PayPb;

/**
 * Class PbController
 * @package App\Controller
 * @Route("/pb")
 */
class PbController extends Controller
{
    /**
     * @Route("/api", name="pb_homepage")
     */
    public function index()
    {
        return $this->render('pb/index.html.twig', [
            'controller_name' => 'PbController',
        ]);
    }
    /**
     * @Route("/", name="pb_pay_pb")
     */
    public function test(Request $request)
    {
        $model = new PayPb();

        $form = $this->createForm(PayPbType::class, $model);
        $form->handleRequest($request);

        $result = '';

        if ($form->isSubmitted() && $form->isValid()) {
            $client = new ApiClient();

            //$model->setTest(1);
            $result = $client->send($model);
        }

        return $this->render('pb/pay-pb.html.twig', [
            'form' => $form->createView(),
            'result' => $result
        ]);
    }
}
