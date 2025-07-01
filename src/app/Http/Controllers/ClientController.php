<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


class ClientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clients",
     *     tags={"Clients"},
     *     summary="Get all clients",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of clients",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="List of clients retrieved successfully."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Client")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'message' => 'List of clients retrieved successfully.',
            'data' => Client::all(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/clients/{id}",
     *     tags={"Clients"},
     *     summary="Get a specific client",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Client retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Client")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Client not found")
     * )
     */
    public function show($id)
    {
        $client = Client::find($id);

        if (!$clientt) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        return response()->json([
            'message' => 'Client retrieved successfully.',
            'data' => $client,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/clients",
     *     tags={"Clients"},
     *     summary="Create a new client",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Client Name"),
     *             @OA\Property(property="description", type="string", example="Client description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Client created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Client")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $client = Client::create($validated);

        return response()->json([
            'message' => 'Client created successfully.',
            'data' => $client,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/clients/{id}",
     *     tags={"Clients"},
     *     summary="Update a specific client",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Updated Client Name"),
     *             @OA\Property(property="description", type="string", example="Updated description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Client updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Client")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Client not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $client->update($validated);

        return response()->json([
            'message' => 'Client updated successfully.',
            'data' => $client,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/clients/{id}",
     *     tags={"Clients"},
     *     summary="Delete a specific client",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client deleted successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Client deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Client not found")
     * )
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        $client->delete();

        return response()->json(['message' => 'Client deleted successfully.']);
    }
}