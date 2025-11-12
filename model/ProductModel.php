<?php

require "BaseModel.php";

class ProductModel extends BaseModel
{

  function showAll()
  {
    $query = $this->db->prepare("SELECT * FROM producto ");
    $query->execute();
    $products = $query->fetchALL(PDO::FETCH_OBJ);
    return $products;
  }

  function insertProduct($nombre_producto, $descripcion_producto, $precio_producto, $fk_id_categoria)
  {
    $query = $this->db->prepare('INSERT INTO producto(nombre_producto,descripcion_producto,precio_producto,fk_id_categoria)
     VALUES (?,?,?,?)');
    $query->execute([$nombre_producto, $descripcion_producto, $precio_producto, $fk_id_categoria]);
  }

  function showProductsByCategory($fk_id_categoria)
  {
    $query = $this->db->prepare("SELECT * FROM producto p 
                                 JOIN categoria c 
                                 ON p.fk_id_categoria = c.id_categoria
                                 WHERE c.id_categoria = ?");
    $query->execute([$fk_id_categoria]);
    return $query->fetchAll(PDO::FETCH_OBJ);
  }

function updateProduct($id_producto, $nombre_producto, $descripcion_producto, $precio_producto, $fk_id_categoria)
{
    $query = $this->db->prepare("UPDATE producto 
        SET nombre_producto = ?, 
            descripcion_producto = ?, 
            precio_producto = ?, 
            fk_id_categoria = ? 
        WHERE id_producto = ?");
    $query->execute([$nombre_producto, $descripcion_producto, $precio_producto, $fk_id_categoria, $id_producto]);
}

function getProductById($id_producto)
{
    $query = $this->db->prepare("SELECT * FROM producto WHERE id_producto = ?");
    $query->execute([$id_producto]);
    return $query->fetch(PDO::FETCH_OBJ);
}

  function deleteProduct($id_producto)
  {
    $query = $this->db->prepare("DELETE FROM producto WHERE id_producto=?");
    $query->execute([$id_producto]);
  }
}
