<?php

namespace App\Controller;

use App\Document\AdTradeResult;
use App\Document\Task;
use App\Entity\AlgorithmParam;
use App\Form\TaskInputType;
use App\Model\TaskInput;
use App\Service\TaskManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Profile;

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
     * @var DocumentManager
     */
    private $dm;

    /**
     * TaskController constructor.
     * @param TaskManager $tm
     * @param DocumentManager $dm
     */
    public function __construct(TaskManager $tm, DocumentManager $dm)
    {
        $this->tm = $tm;
        $this->dm = $dm;
    }

    /**
     * @Route("/{profile_id}", name="task_index", methods="GET", requirements={"profile_id"="\d+"})
     */
    public function index(Request $request): Response
    {
        $profileId = intval($request->get('profile_id'));

        $tasks = $this->dm->getRepository(Task::class)->findBy(['profile_id'=>$profileId]);

        $profile = $this->getDoctrine()->getRepository(Profile::class)->find($profileId);

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'profile' => $profile
        ]);
    }
    /**
     * @Route("/{id}/results", name="task_results", methods="GET")
     */
    public function results(Request $request): Response
    {
        $taskId = $request->get('id');
        /** @var Task $task */
        $task = $this->dm->getRepository(Task::class)
            ->find($taskId);

        if (!$task) {
            throw new DocumentNotFoundException();
        }

        $sh = preg_replace('#(src/.+)$#', 'bin/console', dirname(__FILE__));
        // Execute task
        /** @var Process $proc */
        $proc = new Process([
            $sh,
            $task->getCommand(),
            $taskId
        ]);

        $proc->start();

        $proc->wait(function ($type, $buffer) {
   /*         if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }*/
        });

        $task = $this->dm->getRepository(Task::class)
            ->find($taskId);

        return $this->render('task/_results.html.twig', [
            'results' => $task->getResults()
        ]);
    }
    /**
     * @Route("/{id}/status", name="task_status", methods="POST")
     */
    public function status(): Response
    {
        // TODO: Start / Stop Task

        return new Response('NOT IMPLEMENTED');
    }
    /**
     * @Route("/{id}", name="task_show", methods="GET")
     */
    public function show(Request $request, TaskInput $task): Response
    {
        /** @var Task $doc */
        $doc = $this->dm->getRepository(Task::class)
            ->find($request->get('id'));

        $task->setAttrs($doc->getAttrs());

        $params = [];
        /** @var AlgorithmParam $param */
        foreach ($task->getAlgorithm()->getParams() as $param) {
            $params[] = [
                'label' => sprintf("%s [%s]", $param->getTitle(), $param->getName()),
                'value' => $task->getParams()->getAttrs($param->getName())
            ];
        }

        return $this->render('task/show.html.twig', [
            'task' => $task,
            'params' => $params,
            'results' => $task->getResults()
        ]);
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
        $task->setAd($request->get('ad_id'));

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
            $params = $request->get($form->getName())['params'];
            $params['ad_id'] = $task->getAd()->getAdId();
            $task->setParams($params);

            try {
                $task = $this->tm->createTask($task);

                return $this->redirectToRoute('task_show', ['id' => $task->getId()]);

            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }
}
