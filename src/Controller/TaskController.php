<?php

namespace App\Controller;

use App\Document\Task;
use App\Form\TaskInputType;
use App\Model\TaskInput;
use App\Service\TaskManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/task")
 */
class TaskController extends Controller
{
    /**
     * @var TaskManager
     */
    private $tm;

    /**
     * TaskController constructor.
     * @param TaskManager $tm
     */
    public function __construct(TaskManager $tm)
    {
        $this->tm = $tm;
    }

    /**
     * @Route("/", name="task_index", methods="GET")
     */
    public function index(): Response
    {
        /*$profiles = $this->getDoctrine()
            ->getRepository(Task::class)
            ->findAll();

        return $this->render('task/index.html.twig', ['profiles' => $profiles]);*/
    }

    /**
     * @Route("/{id}", name="task_show", methods="GET")
     */
    public function show(TaskInput $task): Response
    {
        return $this->render('task/show.html.twig', ['task' => $task]);
    }

    /**
     * @Route("/{id}/edit", name="task_edit", methods="GET|POST")
     */
    public function edit(Request $request, TaskInput $task): Response
    {
/*        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_edit', ['id' => $profile->getId()]);
        }

        return $this->render('profile/edit.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);*/
    }

    /**
     * @Route("/{id}", name="task_delete", methods="DELETE")
     */
    public function delete(Request $request, Task $task): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            // todo $this->tm->deleteTask($task)
        }

        return $this->redirectToRoute('task_index');
    }

    /**
     * @Route("/new/{profile_id}/{ad_id}", name="create_task_ad", methods="GET", requirements={"ad_id"="\d+"})
     */
    public function newAd(Request $request, TaskInput $task): Response
    {
        $task->setAdId($request->get('ad_id'));

        return $this->new($request, $task);
    }
    /**
     * @Route("/new/{profile_id}/{command}", name="create_task_cmd", methods="GET")
     */
    public function newCommand(Request $request, TaskInput $task): Response
    {
        $task->setCommand($request->get('command'));

        return $this->new($request, $task);
    }
    /**
     * @Route("/new/{profile_id}", name="create_task", methods="GET|POST")
     */
    public function new(Request $request, TaskInput $task): Response
    {
        $task->setProfileId($request->get('profile_id'));

        $form = $this->createForm(TaskInputType::class, $task);
        $form->handleRequest($request);

        if ($request->isXmlHttpRequest() && $request->get('ajax') == 'params') {

            if ($task->getAlgorithm()) {

                return $this->render('task/_form-params.html.twig', [
                    'form' => $form->createView()
                ]);
            } else {
                return new Response('<i>Параметры не найдены</i>');
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tm->createTask($task);

            return $this->redirectToRoute('task_show', ['id' => $task->getProfileId()]);
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }
}
