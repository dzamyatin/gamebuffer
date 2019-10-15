<?php

namespace App\Controller;

use App\Entity\GameBuffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/gamebuffer")
 */
class GameBufferController extends AbstractController
{
    /**
     * @Route(methods={"POST"})
     */
    public function create(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $number = 0;
        $decodedData = $serializer->decode($request->getContent(), 'json');
        foreach ($this->transformToList($decodedData) as $decodedElement) {
            $number++;
            $gameBuffer = $serializer->denormalize($decodedElement, GameBuffer::class);
            if ($errors = (string)$validator->validate($gameBuffer)) {
                throw new BadRequestHttpException('Element ' . $number . ' has error: ' . $errors);
            }
            $entityManager->persist($gameBuffer);
        }
        $entityManager->flush();
        return $this->json(['created' => $number], Response::HTTP_CREATED);
    }

    private function transformToList(array $array): array
    {
        return array_keys($array) == range(0, count($array) - 1) ?
            $array :
            [$array];
    }
}
