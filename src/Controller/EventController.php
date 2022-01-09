<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Node;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/panelevent/{id}", name="panelevent")
     */
    public function index($id, EntityManagerInterface $entityManager)
    {
        $nodeRepository = $entityManager->getRepository(Node::class);
        $eventRepository = $entityManager->getRepository(Event::class);
        $node=$nodeRepository->find($id);
        $events = $node->getEvent();
        return $this->render('event/panel_event.twig', compact('events')
        );
    }

    /**
     * @Route("/event/{id}", name="event")
     */
    public function eventnode($id, EntityManagerInterface $entityManager)
    {
        $eventRepository = $entityManager->getRepository(Event::class);
        $event = $eventRepository->find($id);

        return $this->render('event/event.twig', compact('event'));
    }

    /**
     * @Route("/createevent/{id}", name="event_create")
     */
    public function createevent($id,Request $request, EntityManagerInterface $entityManager)
    {
        $event = new Event();
        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        $nodeRepository = $entityManager->getRepository(Node::class);
        $event->setNode($nodeRepository->find($id));
        dump($event);


        if ($eventForm->isSubmitted()) {
            if ($eventForm->isValid()) {

                $entityManager->persist($event);
                $entityManager->flush();
            }
        }

        return $this->render('event/create_event.twig'
            ,
            [
                'eventForm' => $eventForm->createView(),
            ]
        );
    }
}
