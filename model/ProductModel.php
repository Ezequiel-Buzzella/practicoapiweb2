  <?php

  require "BaseModel.php";

  class ProductModel extends BaseModel
  {


    public function showAll($sort = null, $order = 'ASC')
    {
      $allowedColumns = ['id_producto', 'nombre_producto', 'precio_producto', 'fk_id_categoria'];
      $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

      $sql = "SELECT * FROM producto p 
            JOIN categoria c ON p.fk_id_categoria = c.id_categoria";

      if ($sort && in_array($sort, $allowedColumns)) {
        $sql .= " ORDER BY $sort $order";
      }

      $query = $this->db->prepare($sql);
      $query->execute();

      return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function showAllOrdered($column, $direction = 'ASC')
    {

      $allowedColumns = ['id_producto', 'nombre_producto', 'precio_producto', 'fk_id_categoria'];
      if (!in_array($column, $allowedColumns)) {
        $column = 'id_producto';
      }

      $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';


      $query = $this->db->prepare("SELECT * FROM producto ORDER BY $column $direction");
      $query->execute();
      $products = $query->fetchAll(PDO::FETCH_OBJ);

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
