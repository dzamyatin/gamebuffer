<?php

namespace App\Translator;

use App\Event\TranslatedEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\CacheTranslator as Cache;

class CacheTranslator implements TranslatorInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function translate(string $string): ?string
    {
        /** @var Cache $entity */
        $entity = $this->entityManager->find(Cache::class, $string);
        return $entity ? $entity->getTranslation() : null;
    }

    public function listen(TranslatedEvent $event): void
    {
        $this->entityManager->merge(
            (new Cache())
                ->setSource($event->getSource())
                ->setTranslation($event->getTranslation())
        );
        $this->entityManager->flush();
    }
}