<?php

namespace App\EventSubscriber;

use App\Entity\Conference;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setAuthorConference'],
        ];
    }

    public function setAuthorConference(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Conference)) {
            return;
        }

        // $slug = $this->slugger->slugify($entity->getTitle());
        $user = $this->security->getUser();
        $entity->setAuthor($user);
    }
}
