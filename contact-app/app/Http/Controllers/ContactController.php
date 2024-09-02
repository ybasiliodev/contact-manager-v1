<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Services\ContactService;
use App\Services\UserService;

class ContactController extends Controller
{
    public function __construct(Contact $contact, ContactService $contactService)
    {
        $this->contact = $contact;
        $this->contactService = $contactService;
    }

    /**
    * @OA\Get(path="/api/v1/contact/{id}",
    *     tags={"Contato"},
    *     summary="Buscar contato por id",
    *     operationId="getContact",
    *     @OA\Response(response="200", description="Retorna endereço"),
    *     @OA\Response(response="404", description="Contato não encontrado!"),
    *     security={{ "apiAuth": {} }}
    * )
    */
    public function show($id)
    {
        $data = $this->contactService->getContact($id);
        return response()->json($data['message'], $data['status']);
    }

        /**
    * @OA\Post(path="/api/v1/contact",
    *     tags={"Contato"},
    *     summary="Criar novo contato",
    *     operationId="createContact",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                  @OA\Property(property="name", type="string"),
    *                  @OA\Property(property="social_number", type="string"),
    *                  @OA\Property(property="phone", type="string"),
    *                  @OA\Property(property="postal_code", type="string"),
    *                  @OA\Property(property="city", type="string"),
    *                  @OA\Property(property="state", type="string"),
    *                  @OA\Property(property="address", type="string"),
    *                  @OA\Property(property="address_complement", type="string"),
    *                  @OA\Property(property="lat", type="string"),
    *                  @OA\Property(property="lon", type="string"),
    *                  required={"name", "social_number", "phone", "postal_code","city","state","address","lat", "lon"}
    *             )
    *         )
    *      ),
    *     @OA\Response(response="201", description="Contato Incluido com sucesso"),
    *     @OA\Response(response="422", description="Campos inválidos"),
    *     security={{ "apiAuth": {} }}
    * )
    */
    public function store(Request $request)
    {
        $data = $this->contactService->createContact($request);
        return response()->json($data['message'], $data['status']);
    }

           /**
    * @OA\Post(path="/api/v1/contact/{id}",
    *     tags={"Contato"},
    *     summary="Atualiza contato existente",
    *     operationId="updateContact",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                  @OA\Property(property="name", type="string"),
    *                  @OA\Property(property="social_number", type="string"),
    *                  @OA\Property(property="phone", type="string"),
    *                  @OA\Property(property="postal_code", type="string"),
    *                  @OA\Property(property="city", type="string"),
    *                  @OA\Property(property="state", type="string"),
    *                  @OA\Property(property="address", type="string"),
    *                  @OA\Property(property="address_complement", type="string"),
    *                  @OA\Property(property="lat", type="string"),
    *                  @OA\Property(property="lon", type="string"),
    *                  required={"name", "social_number", "phone", "postal_code","city","state","address","lat", "lon"}
    *             )
    *         )
    *      ),
    *     @OA\Response(response="200", description="Contato atualizado com sucesso"),
    *     @OA\Response(response="404", description="Contato não encontrado!"),
    *     @OA\Response(response="422", description="Campos inválidos"),
    *     security={{ "apiAuth": {} }}
    * )
    */
    public function update(Request $request, $id)
    {
        $data = $this->contactService->updateContact($request, $id);
        return response()->json($data['message'], $data['status']);
    }

        /**
    * @OA\Delete(path="/api/v1/contact/{id}",
    *     tags={"Contato"},
    *     summary="Apagar contato por id",
    *     operationId="deleteContact",
    *     @OA\Response(response="204", description="Contato excluido com sucesso"),
    *     @OA\Response(response="404", description="Contato não encontrado!"),
    *     security={{ "apiAuth": {} }}
    * )
    */
    public function destroy($id)
    {
        $data = $this->contactService->deleteContact($id);
        return response()->json($data['message'], $data['status']);
    }

    /**
    * @OA\Get(path="/api/v1/contact/list",
    *     tags={"Contato"},
    *     summary="Buscar todos os contatos do usuário por paginação e ordenação",
    *     operationId="showByUser",
    *     @OA\Parameter(name="perPage",in="query", description="Quantos contatos por página (padrão 10)"),
    *     @OA\Parameter(name="name",in="query", description="Filtrar por nome ou parte do nome"),
    *     @OA\Parameter(name="cpf",in="query", description="Filtrar por cpf ou parte do cpf"),
    *     @OA\Parameter(name="sort",in="query", description="Por qual dos campos vai ser ordenado (name ou social_number separados por virgula e com - para desc)"),
    *     @OA\Response(response="200", description="Retorna lista de usuários"),
    *     @OA\Response(response="404", description="Contato não encontrado!"),
    *     security={{ "apiAuth": {} }}
    * )
    */
    public function showByUser(Request $request)
    {
        $contact = $this->contactService->filterContactResults($request, $this->contact);
        return response()->json($contact, 200);
    }
}
