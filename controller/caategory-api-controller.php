<?php
require_once './model/CategoryModel.php';

class CategoryApiController {
    private $model;

    public function __construct() {
        $this->model = new CategoryModel();
    }


    public function getAll($request, $response) {
        $categories = $this->model->showAll();
        return $response->json($categories, 200);
    }


    public function getById($request, $response) {
        $id = $request->params->id ?? null;

        if (!$id) {
            return $response->json(['error' => 'Falta el ID'], 400);
        }

        $category = $this->model->getById($id);
        if (!$category) {
            return $response->json(['error' => 'Categoría no encontrada'], 404);
        }

        return $response->json($category, 200);
    }

    public function notFound($request, $response) {
        return $response->json(['error' => 'Ruta no encontrada'], 404);
    }
}

