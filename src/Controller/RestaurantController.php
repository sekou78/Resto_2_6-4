<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
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

#[Route('api/restaurant', name: 'app_api_restaurant_')]
class RestaurantController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $manager,
        private RestaurantRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator
    )
    {
        
    }

    #[Route(name: 'new', methods: 'POST')]
    #[OA\Post(
        path:"/api/restaurant",
        summary:"Inscription d'un nouveau restaurant",
        requestBody: new OA\RequestBody(
            required: true,
            description: "Données du nouveau à inscrire",
            content: new OA\MediaType(
                mediaType:"application/json",
                schema: new OA\Schema(
                    type: "object",
                    required: ["name", "description", "maxGuest"],
                    properties: [
                        new OA\Property(
                            property: "name",
                            type: "string",
                            example: "Mon new Resto"
                        ),
                        new OA\Property(
                            property: "description",
                            type: "string",
                            example: "Mon new resto à découvrir"
                        ),
                        new OA\Property(
                            property: "maxGuest",
                            type: "smallint",
                            example: "60"
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Utilisateur inscrit avec succès",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "name",
                                type: "string",
                                example: "Mon new Resto"
                            ),
                            new OA\Property(
                                property: "description",
                                type: "string",
                                example: "Mon new resto à decouvrir"
                            ),
                            new OA\Property(
                                property: "maxGuest",
                                type: "smallint",
                                example: "60"
                            )
                        ]
                    )
                )
            )
        ]
    )]
    public function new(Request $request): JsonResponse
    {
        $restaurant = $this->serializer->deserialize($request->getContent(), Restaurant::class, 'json');
        $restaurant->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($restaurant);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($restaurant, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_restaurant_show',
            ['id' => $restaurant->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);

    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    #[OA\Get(
        path: "/api/restaurant/{id}",
        summary: "Afficher un restaurant par ID",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID du restaurant à afficher",
                schema: new OA\Schema(
                    type: "integer"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Restaurant trouvé avec succès",
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
                                example: "Description du Restaurant"
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
                description: "Restaurant non trouvé"
            )
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $restaurant = $this->repository->findOneBy(['id' => $id]);
        if ($restaurant) {
            $responseData = $this->serializer->serialize($restaurant, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    #[OA\Put(
        path: "/api/restaurant/{id}",
        summary: "Mise à jour du restaurant",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID du restaurant à modifier",
                schema: new OA\Schema(
                    type: "integer"
                )
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: "Données du restaurant à modifier",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    type: "object",
                    required: ["name", "description", "maxGuest"],
                    properties: [
                        new OA\Property(
                            property: "name",
                            type: "string",
                            example: "Nom du restaurant à modifier"
                        ),
                        new OA\Property(
                            property: "description",
                            type: "string",
                            example:"Description du restaurant à modifier"
                        ),
                        new OA\Property(
                            property: "amOpeningTime",
                            type: "string",
                            example: ["06:30"]
                        ),
                        new OA\Property(
                            property: "pmOpeningTime",
                            type: "string",
                            example: ["21:30"]
                        ),
                        new OA\Property(
                            property: "maxGuest",
                            type: "integer",
                            example: 200
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 204,
                description: "Restaurant modifé avec succès",
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
                                example: "Description du Restaurant à modifier"
                            ),
                            new OA\Property(
                                property: "updatedAt",
                                type: "string",
                                format: "date-time"
                            )
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 404,
                description: "Restaurant non trouvé"
            )
        ]
    )]
    public function edit(int $id, Request $request): JsonResponse
    {
        $restaurant = $this->repository->findOneBy(['id' => $id]);
        if ($restaurant) {
            $restaurant = $this->serializer->deserialize(
                $request->getContent(),
                Restaurant::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $restaurant]
            );

            $restaurant->setUpdatedAt(new DateTimeImmutable());
    
            $this->manager->flush();
    
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    #[OA\Delete(
        path: "/api/restaurant/{id}",
        summary: "Suppression du restaurant",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID du restaurant à supprimer",
                schema: new OA\Schema(
                    type: "integer"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: "Restaurant supprimer avec succès",
            ),
            new OA\Response(
                response: 404,
                description: "Restaurant non trouvé"
            )
        ]
    )]
    public function delete(int $id): JsonResponse
    {
        $restaurant = $this->repository->findOneBy(['id' => $id]);
        if ($restaurant) {
            $this->manager->remove($restaurant);
            $this->manager->flush();

            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
