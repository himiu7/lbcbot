<?php

namespace App\Controller;

use App\Api\LbcBundle\DataProvider;
use App\Document\Ad;
use App\Entity\Profile;
use App\Service\TaskManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package App\Controller
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @var TaskManager
     */
    private $tm;

    /**
     * DefaultController constructor.
     * @param TaskManager $tm
     */
    public function __construct(TaskManager $tm)
    {
        $this->tm = $tm;
    }

    /**
     * @Route("/", name="dashboard")
     */
    public function indexAction()
    {
        /** @var Profile $profile */
        /*$profile = $this->getDoctrine()->getRepository(Profile::class)->find(1);

        $ads = $this->tm->getUserAds($profile);*/

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            //'ads' => print_r($ads, true)
        ]);
    }

}
