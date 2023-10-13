<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function list(ManagerRegistry $doctrine): Response
    {
        $tasks = $doctrine->getRepository(Task::class)->findAll();

        return $this->render('task/list.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/tasks/{id}", name="task_view")
     */
    public function view($id,ManagerRegistry $doctrine): Response
{
    $task = $doctrine->getRepository(Task::class)->find($id);

    if (!$task) {
        throw $this->createNotFoundException('Задача не найдена');
    }

    return $this->render('task/view.html.twig', ['task' => $task]);
}

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function create(Request $request,ManagerRegistry $doctrine): Response
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
    
        $form->handleRequest($request);

    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($task);
            $entityManager->flush();
    
            return $this->redirectToRoute('task_view', ['id' => $task->getId()]);
        }


        $errors = $form->getErrors(true, false);
    
        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);

    }

    /**
     * @Route("/add-categories", name="add_categories")
     */
    public function addCategories(EntityManagerInterface $entityManager)
    {
        $category1 = new Category();
        $category2 = new Category();

        $category1->setName('Категория 1');
        $category2->setName('Категория 2');

        $entityManager->persist($category1);
        $entityManager->persist($category2);
        $entityManager->flush();

        return $this->redirectToRoute('task_list');
    }

/**
 * @Route("/tasks/{id}/update", name="task_update")
 */
public function update($id, Request $request, ManagerRegistry $doctrine): Response
{
    $entityManager = $doctrine->getManager();
$task = $entityManager->getRepository(Task::class)->find($id);

if (!$task) {
    throw $this->createNotFoundException('Задача не найдена');
}

$form = $this->createForm(TaskType::class, $task);

$form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('task_list');
    }

return $this->render('task/update.html.twig', [
    'task' => $task,
    'form' => $form->createView(),
]);


}

/**
 * @Route("/tasks/{id}/delete", name="task_delete")
 */
public function delete($id,ManagerRegistry $doctrine): Response
{
    $entityManager = $doctrine->getManager();
    $task = $entityManager->getRepository(Task::class)->find($id);

    if (!$task) {
        throw $this->createNotFoundException('Задача не найдена');
    }

    $entityManager->remove($task);
    $entityManager->flush();

    return $this->redirectToRoute('task_list');
}
}
