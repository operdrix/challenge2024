<?php

namespace App\Controller\App;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Form\Type\ChatType;
use App\Form\Type\StudentFilterType;
use App\Form\Type\TeacherFilterType;
use App\Service\Interface\FilteredListServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Écran chat
 */
#[Route('/chat', name: 'chat_')]
class ChatController extends AbstractController
{
    /**
     * Liste des chats
     */
    #[Route('/', name: 'index')]
    public function index(
        FilteredListServiceInterface $filteredListService,
        Request $request
    ): Response {
        $user = $this->getUser();

        if ($user instanceof Teacher) {
            $filters = [
                "teacher" => $this->getUser()
            ];

            [$pagination, $form] = $filteredListService->prepareFilteredList(
                $request,
                StudentFilterType::class,
                Student::class,
                $filters
            );
        } else {
            $filters = [
                "student" => $this->getUser()
            ];

            [$pagination, $form] = $filteredListService->prepareFilteredList(
                $request,
                TeacherFilterType::class,
                Teacher::class,
                $filters
            );
        }

        return $this->render(
            'chat/index.html.twig',
            [
                "pagination" => $pagination,
                "form" => $form,
                "user_class" => $user::class
            ]
        );
    }

    /**
     * Conversation
     */
    #[Route("/{idStudent}/{idTeacher}/conversation", name: "conversation")]
    public function conversation(
        Request                $request,
        HubInterface           $hub,
        #[MapEntity(id: "idStudent")] Student                $student,
        #[MapEntity(id: "idTeacher")] Teacher                $teacher,
        EntityManagerInterface $em
    ): Response {
        $conversation = $em->getRepository(Conversation::class)->findOneBy([
            "teacher" => $teacher,
            "student" => $student
        ]);

        if (empty($conversation)) {
            $conversation = new Conversation();
            $conversation->setTeacher($teacher);
            $conversation->setStudent($student);
            $em->persist($conversation);
            $em->flush();
        }

        $message = new Message();
        $message->setCreatedBy($this->getUser()->getUserIdentifier());
        $conversation->addMessage($message);

        $form = $this->createForm(ChatType::class, $message);

        $emptyForm = clone $form; // Used to display an empty form after a POST request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $hub->publish(new Update(
                "conversation" . $conversation->getId(),
                $this->renderView("chat/message.stream.html.twig", ["message" => $message])
            ));

            $form = $emptyForm;
        }

        return $this->render('chat/conversation.html.twig', [
            'form' => $form,
            "conversation" => $conversation
        ]);
    }
}
