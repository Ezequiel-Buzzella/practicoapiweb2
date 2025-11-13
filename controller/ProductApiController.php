<?php

require_once './model/ProductModel.php';

class ProductApiController
{
    private $model;

    public function __construct()
    {
        $this->model = new ProductModel();
    }

public function getAll($request, $response)
{
    $sort = $_GET['sort'] ?? null;
    $order = $_GET['order'] ?? 'ASC';

    $products = $this->model->showAll($sort, $order);

    return $response->json($products, 200);
}



    public function getById($request, $response)
    {
        $id = $request->params->id ?? null;

        if (!$id) {
            return $response->json(['error' => 'Falta el ID'], 400);
        }

        $product = $this->model->getProductById($id);
        if (!$product) {
            return $response->json(['error' => 'Producto no encontrado'], 404);
        }

        return $response->json($product, 200);
    }


    public function create($request, $response)
    {
        $data = $request->body;

        if (
            !$data ||
            !isset($data->nombre_producto) ||
            !isset($data->precio_producto) ||
            !isset($data->fk_id_categoria)
        ) {
            return $response->json(['error' => 'Datos incompletos'], 400);
        }

        $this->model->insertProduct(
            $data->nombre_producto,
            $data->descripcion_producto ?? '',
            $data->precio_producto,
            $data->fk_id_categoria
        );

        return $response->json(['message' => 'Producto creado correctamente'], 201);
    }


    public function update($request, $response)
    {
        $id = $request->params->id ?? null;
        $data = json_decode(file_get_contents('php://input'));

        if (!$id || !$data) {
            return $response->json(['error' => 'Datos incompletos'], 400);
        }

        $product = $this->model->getProductById($id);
        if (!$product) {
            return $response->json(['error' => 'Producto no encontrado'], 404);
        }

        $this->model->updateProduct(
            $id,
            $data->nombre_producto ?? $product->nombre_producto,
            $data->descripcion_producto ?? $product->descripcion_producto,
            $data->precio_producto ?? $product->precio_producto,
            $data->fk_id_categoria ?? $product->fk_id_categoria
        );

        return $response->json(['message' => 'Producto actualizado correctamente'], 200);
    }

    public function delete($request, $response)
    {
        $id = $request->params->id ?? null;

        if (!$id) {
            return $response->json(['error' => 'Falta el ID'], 400);
        }

        $product = $this->model->getProductById($id);
        if (!$product) {
            return $response->json(['error' => 'Producto no encontrado'], 404);
        }

        $this->model->deleteProduct($id);
        return $response->json(['message' => 'Producto eliminado correctamente'], 200);
    }


    public function notFound($request, $response)
    {
        return $response->json(['error' => 'Ruta no encontrada'], 404);
    }
}
