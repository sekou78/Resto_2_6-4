<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[Route('api/booking', name: 'app_api_booking_')]
class BookingController extends AbstractController
{
    
    public function __construct(
        private EntityManagerInterface $manager,
        private BookingRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator
        )
        {
            
        }
        
        #[Route(name: 'new', methods: 'POST')]
        #[OA\Post(
            path: "/api/booking",
            summary: "Créer un booking",
            requestBody: new OA\RequestBody(
                required: true,
                description: "Données du booking à créer",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["guestNumber", "orderDate", "orderHour", "allergy"],
                        properties: [
                            new OA\Property(
                                property: "guestNumber",
                                type: "integer",
                                example: 5
                            ),
                            new OA\Property(
                                property: "orderDate",
                                type: "string",
                                format: "date-time",
                                example:"2024-04-17"
                            ),
                            new OA\Property(
                                property: "orderHour",
                                type: "string",
                                format: "hour-time",
                                example:"2024-04-17 16:30"
                            ),
                            new OA\Property(
                                property: "allergy",
                                type: "string",
                                example:"Cacahuètes"
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: 201,
                    description: "booking créer avec succès",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "id",
                                    type: "integer",
                                    example: 1
                                ),
                                new OA\Property(
                                    property: "guestNumber",
                                    type: "integer",
                                    example: 5
                                ),
                                new OA\Property(
                                    property: "orderDate",
                                    type: "string",
                                    format: "date-time",
                                    example:"2024-04-17"
                                ),
                                new OA\Property(
                                    property: "orderHour",
                                    type: "string",
                                    format: "hour",
                                    example:"2024-04-17 16:30"
                                ),
                                new OA\Property(
                                    property: "allergy",
                                    type: "string",
                                    example:"Cacahuètes"
                                )
                            ]
                        )
                    )
                )
            ]
        )]
    public function new(Request $request): JsonResponse
    {
        $booking = $this->serializer->deserialize($request->getContent(), Booking::class, 'json');
        $booking->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($booking);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($booking, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_booking_show',
            ['id' => $booking->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);

    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    #[OA\Get(
        path: "/api/booking/{id}",
        summary: "Afficher un booking par ID",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID du booking à afficher",
                schema: new OA\Schema(
                    type: "integer"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Booking trouvé avec succès",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "id",
                                type: "integer",
                                example: 1
                            ),
                            new OA\Property(
                                property: "name",
                                type: "string",
                                example: "Description du Bbooking"
                            ),
                            new OA\Property(
                                property: "createdAt",
                                type: "string",
                                format: "date-time"
                            )
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: "Booking non trouvé"
            )
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $booking = $this->repository->findOneBy(['id' => $id]);
        if ($booking) {
            $responseData = $this->serializer->serialize($booking, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    #[OA\Put(
        path: "/api/booking/{id}",
        summary: "Mise à jour du booking",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID du booking à modifier",
                schema: new OA\Schema(
                    type: "integer"
                )
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Données du booking à modifier",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    type: "object",
                    required: ["guestNumber", "orderDate", "orderHour", "allergy"],
                    properties: [
                        new OA\Property(
                            property: "guestNumber",
                            type: "integer",
                            example: 55
                        ),
                        new OA\Property(
                            property: "orderDate",
                            type: "string",
                            format: "date-time",
                            example: "2024-04-17"
                        ),
                        new OA\Property(
                            property: "orderHour",
                            type: "string",
                            format: "hour",
                            example: "2024-04-17 16:30"
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 204,
                description: "Booking modifé avec succès",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "id",
                                type: "integer",
                                example: 1
                            ),
                            new OA\Property(
                                property: "guestNumber",
                                type: "integer",
                                example: 55
                            ),
                            new OA\Property(
                                property: "orderDate",
                                type: "string",
                                format: "date-time",
                                example: "2024-04-17"
                            ),
                            new OA\Property(
                                property: "orderHour",
                                type: "string",
                                format: "hour",
                                example: "2024-04-17 16:30"
                            )
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: "Booking non trouvé"
            )
        ]
    )]
    public function edit(int $id, Request $request): JsonResponse
    {
        $booking = $this->repository->findOneBy(['id' => $id]);
        if ($booking) {
            $booking = $this->serializer->deserialize(
                $request->getContent(),
                Booking::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $booking]
            );

            $booking->setUpdatedAt(new DateTimeImmutable());
    
            $this->manager->flush();
    
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    #[OA\Delete(
        path: "/api/booking/{id}",
        summary: "Suppression du booking",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID du booking à supprimer",
                schema: new OA\Schema(
                    type: "integer"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "Booking supprimer avec succès",
            ),
            new OA\Response(
                response: 404,
                description: "Booking non trouvé"
            )
        ]
    )]
    public function delete(int $id): JsonResponse
    {
        $booking = $this->repository->findOneBy(['id' => $id]);
        if ($booking) {
            $this->manager->remove($booking);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}