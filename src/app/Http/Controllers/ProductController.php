<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
// EncryptionHelper tidak lagi digunakan, bisa dihapus jika tidak ada fungsi lain yang memakai
// use App\Helper\EncryptionHelper; 

class ProductController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/products",
     * operationId="getProducts",
     * tags={"Products"},
     * summary="Get all products",
     * description="Returns a list of all products.",
     * security={{"ApiKeyAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="message", type="string", example="success"),
     * @OA\Property(
     * property="data",
     * type="array",
     * @OA\Items(ref="#/components/schemas/Product")
     * )
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Unauthorized - Invalid API Key"
     * )
     * )
     */
    public function index()
    {
        $data = Product::all();

        $responseData = [
            'message' => 'success',
            'data' => $data,
        ];

        // Langsung kembalikan data tanpa enkripsi
        return response()->json($responseData);
    }

    /**
     * @OA\Post(
     * path="/api/products",
     * operationId="storeProduct",
     * tags={"Products"},
     * summary="Create a new product",
     * description="Stores a new product.",
     * security={{"ApiKeyAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name", "price"},
     * @OA\Property(property="name", type="string", example="Product A"),
     * @OA\Property(property="price", type="number", format="float", example=199.99)
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Product created",
     * @OA\JsonContent(
     * ref="#/components/schemas/Product"
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Error storing product",
     * @OA\JsonContent(
     * @OA\Property(property="error", type="string", example="Error storing product: ...")
     * )
     * )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        try {
            $product = Product::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
            ]);

            $responseData = [
                'message' => 'Product created successfully',
                'data' => $product,
            ];

            // Langsung kembalikan data tanpa enkripsi
            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error storing product: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     * path="/api/products/{id}",
     * operationId="getProductById",
     * tags={"Products"},
     * summary="Get a product by ID",
     * description="Returns a single product",
     * security={{"ApiKeyAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="Product ID",
     * @OA\Schema(type="integer", example=1)
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * @OA\JsonContent(
     * ref="#/components/schemas/Product"
     * )
     * ),
     * @OA\Response(response=404, description="Product not found"),
     * @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $responseData = [
            'message' => 'success',
            'data' => $product,
        ];

        // Langsung kembalikan data tanpa enkripsi
        return response()->json($responseData);
    }

    /**
     * @OA\Put(
     * path="/api/products/{id}",
     * operationId="updateProduct",
     * tags={"Products"},
     * summary="Update a product",
     * description="Updates an existing product",
     * security={{"ApiKeyAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="Product ID",
     * @OA\Schema(type="integer", example=1)
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="name", type="string", example="Updated Product"),
     * @OA\Property(property="price", type="number", format="float", example=299.99)
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Product updated successfully",
     * @OA\JsonContent(
     * ref="#/components/schemas/Product"
     * )
     * ),
     * @OA\Response(response=404, description="Product not found"),
     * @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
        ]);

        $product->update($validated);

        $responseData = [
            'message' => 'Product updated successfully',
            'data' => $product,
        ];

        // Langsung kembalikan data tanpa enkripsi
        return response()->json($responseData);
    }

    /**
     * @OA\Delete(
     * path="/api/products/{id}",
     * operationId="deleteProduct",
     * tags={"Products"},
     * summary="Delete a product",
     * description="Deletes a product by ID",
     * security={{"ApiKeyAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="Product ID",
     * @OA\Schema(type="integer", example=1)
     * ),
     * @OA\Response(
     * response=200,
     * description="Product deleted successfully",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Product deleted successfully")
     * )
     * ),
     * @OA\Response(response=404, description="Product not found"),
     * @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        $responseData = [
            'message' => 'Product deleted successfully',
            'data' => ['id' => $id],
        ];

        // Langsung kembalikan data tanpa enkripsi
        return response()->json($responseData);
    }

    // Fungsi decryptResponse() telah dihapus karena tidak lagi diperlukan.
}