<?php

require_once './model/ProductModel.php';

class ProductApiController {
    private $model;

    public function __construct() {
        $this->model = new ProductModel();
    }


    public function getAll($request, $response) {
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
        $order = isset($_GET['order']) ? strtolower($_GET['order']) : 'asc';

        if ($order !== 'asc' && $order !== 'desc') {
            $order = 'asc';
        }

        if (empty($sort)) {
            $products = $this->model->showAll();
        } else {
            $allowed = ['id_producto', 'nombre_producto', 'precio_producto', 'fk_id_categoria'];
            if (!in_array($sort, $allowed)) {
                return $response->json(['error' => 'Campo de ordenamiento inválido'], 400);
            }

            $products = $this->model->showAllOrdered($sort, $order);
        }

        return $response->json($products, 200);
    }


    public function getById($request, $response) {
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


    public function create($request, $response) {
        $data = $request->body;

        if (!$data ||
            !isset($data->nombre_producto) ||
            !isset($data->precio_producto) ||
            !isset($data->fk_id_categoria)) {
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


    public function update($request, $response) {
        $id = $request->params->id ?? null;
        $data = $request->body;

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

    public function delete($request, $response) {
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


    public function notFound($request, $response) {
        return $response->json(['error' => 'Ruta no encontrada'], 404);
    }
}