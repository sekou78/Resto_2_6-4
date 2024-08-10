<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[Route('/api', name: 'app_api_')]
class SecurityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private SerializerInterface $serializer,
        private UserRepository $repository,
        private UserPasswordHasherInterface $passwordHasher,
    )
    {
        
    }

    #[Route('/registration', name: 'registration', methods: 'POST')]
    #[OA\Post(
        path:"/api/registration",
        summary:"Inscription d'un nouvel utilisateur",
        requestBody: new OA\RequestBody(
            required: true,
            description: "Données de l'utilisateur à inscrire",
            content: new OA\MediaType(
                mediaType:"application/json",
                schema: new OA\Schema(
                    type: "object",
                    required: ["email", "password", "firstname", "lastname", "guestNumber", "allergy"],
                    properties: [
                        new OA\Property(
                            property: "email",
                            type: "string",
                            format: "email",
                            example: "adresse@mail.com"
                        ),
                        new OA\Property(
                            property: "password",
                            type: "string",
                            format: "password",
                            example: "mot de passe"
                        ),
                        new OA\Property(
                            property: "firstname",
                            type: "string",
                            example: "Fath"
                        ),
                        new OA\Property(
                            property: "lastname",
                            type: "string",
                            example: "Dinga"
                        ),
                        new OA\Property(
                            property: "guestNumber",
                            type: "smallint",
                            example: "20"
                        ),
                        new OA\Property(
                            property: "allergy",
                            type: "string",
                            example: "cacahuètes"
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
                                property: "user",
                                type: "string",
                                example: "Mail de connexion"
                            ),
                            new OA\Property(
                                property: "apiToken",
                                type: "string",
                                example: "31a023e212f1"
                            ),
                            new OA\Property(
                                property: "roles",
                                type: "array",
                                items: new OA\Items(
                                    type: "string",
                                    example: "ROLE_USER"
                                )
                            ),
                            new OA\Property(
                                property: "firstname",
                                type: "string",
                                example: "Fath"
                            ),
                            new OA\Property(
                                property: "lastname",
                                type: "string",
                                example: "Dinga"
                            ),
                            new OA\Property(
                                property: "guestNumber",
                                type: "smallint",
                                example: "20"
                            ),
                            new OA\Property(
                                property: "allergy",
                                type: "string",
                                example: "cacahuètes"
                            )
                        ]
                    )
                )
            )
        ]
    )]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
        $user->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($user);
        $this->manager->flush();

        return new JsonResponse(
            ['user'  => $user->getUserIdentifier(), 
            'apiToken' => $user->getApiToken(), 
            'roles' => $user->getRoles()
            ],
            Response::HTTP_CREATED
        );
    }

    #[Route('/login', name: 'login', methods: 'POST')]
    #[OA\Post(
        path: "/api/login",
        summary: "Connecter un utilisateur",
        requestBody: new OA\RequestBody(
            required: true,
            description: "Données de l'utilisateur pour se connecter",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    type: "object",
                    required: ["username", "password"],
                    properties: [
                        new OA\Property(
                            property: "username",
                            type: "string",
                            example: "adresse@email.com"
                        ),
                        new OA\Property(
                            property: "password",
                            type: "string",
                            example:"Mot de passe"
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Connexion reussie",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "user",
                                type: "string",
                                example:"adresse de connexion"
                            ),
                            new OA\Property(
                                property: "apiToken",
                                type: "string",
                                example: "31a023e212f"
                            ),
                            new OA\Property(
                                property: "roles",
                                type: "array",
                                items: new OA\Items(
                                    type: "string",
                                    example: "ROLE_USER"
                                )
                            )
                        ]
                    )
                )
            )
        ]
    )]
    public function login(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user) {
            return new JsonResponse(['message' => 'Missing credentials'], Response::HTTP_UNAUTHORIZED);
        }
        return new JsonResponse([
            'user'  => $user->getUserIdentifier(),
            'apiToken' => $user->getApiToken(),
            'roles' => $user->getRoles(),
        ]);
    }

    #[Route('/account/me', name: 'me', methods: 'GET')]
    public function me(): JsonResponse
    {
        $user = $this->getUser();

        $responseData = $this->serializer->serialize($user, 'json');

        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }

    #[Route('/account/edit', name: 'edit', methods: 'PUT')]
    public function edit(Request $request): JsonResponse
    {
        $user = $this->serializer->deserialize(
            $request->getContent(),
            User::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $this->getUser()],
        );
        $user->setUpdatedAt(new DateTimeImmutable());

        if (isset($request->toArray()['password'])) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        }

        $this->manager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
