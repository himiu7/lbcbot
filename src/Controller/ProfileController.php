<?php

namespace App\Controller;

use App\Document\Task;
use App\Entity\Profile;
use App\Form\ProfileType;
use App\Form\TaskInputType;
use App\Model\TaskInput;
use App\Service\TaskManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var TaskManager
     */
    private $tm;
    /**
     * ProfileController constructor.
     * @param EntityManagerInterface $em
     * @param TaskManager $tm
     */
    public function __construct(EntityManagerInterface $em, TaskManager $tm)
    {
        $this->em = $em;
        $this->tm = $tm;
    }

    /**
     * @Route("/", name="profile_index", methods="GET")
     */
    public function index(): Response
    {
        $profiles = $this->getDoctrine()
            ->getRepository(Profile::class)
            ->findAll();

        return $this->render('profile/index.html.twig', ['profiles' => $profiles]);
    }

    /**
     * @Route("/new", name="profile_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $profile = new Profile();
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $profile->setCreatedAt(new \DateTime());

            $profile->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();

            return $this->redirectToRoute('profile_show', [
                'id' => $profile->getId()
            ]);
        }

        return $this->render('profile/new.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profile_show", methods="GET")
     */
    public function show(Profile $profile, TaskInput $task): Response
    {
        $form = $this->createForm(TaskInputType::class, $task);

        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
            'task' => $task,
            'form' => $form->createView(),
            'ads' => $this->tm->getUserAds($profile)
        ]);
    }

    /**
     * @Route("/{id}/edit", name="profile_edit", methods="GET|POST")
     */
    public function edit(Request $request, Profile $profile): Response
    {
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_edit', ['id' => $profile->getId()]);
        }

        return $this->render('profile/edit.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/update-ads", name="profile_update_ads", methods="GET")
     */
    public function updateAds(Request $request): Response
    {
        if ($profileId = $request->get('id')) {
            $profile = $this->em->getRepository(Profile::class)->find($profileId);

            return $this->render('profile\_ads-list.html.twig', [
                    'ads' => $this->tm->getUserAds($profile, ['force' => true]),
                    'profile' => $profile
                ]);
        }

        throw new BadRequestHttpException('Request not allowed');
    }

    /**
     * @Route("/{id}", name="profile_delete", methods="DELETE")
     */
    public function delete(Request $request, Profile $profile): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profile->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profile);
            $em->flush();
        }

        return $this->redirectToRoute('profile_index');
    }
}
