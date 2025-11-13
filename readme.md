🧾 TPE-Web_II_APIrest
Integrantes:

Ezequiel Buzzella — ezequielbuzzella@gmail.com
Manejo de colección de productos mediante API REST

Esta API permite administrar una colección de productos y categorías, con operaciones CRUD completas y soporte para ordenamiento, filtrado y manejo por categorías.
| Función                            | Verbo HTTP | URI                            |
| ---------------------------------- | ---------- | ------------------------------ |
| Obtener listado total de productos | **GET**    | `/api/products`                |
| Obtener un producto por ID         | **GET**    | `/api/products/:id`            |
| Obtener productos por categoría    | **GET**    | `/api/categories/:id/products` |
| Insertar un nuevo producto         | **POST**   | `/api/products`                |
| Modificar un producto existente    | **PUT**    | `/api/products/:id`            |
| Eliminar un producto               | **DELETE** | `/api/products/:id`            |

Parámetros opcionales
Ordenar resultados

Permite ordenar los productos por un campo determinado, ascendente o descendente:

Ejemplo	Descripción
?sort=nombre_producto&order=ASC	Ordena los productos alfabéticamente por nombre.
?sort=precio_producto&order=DESC	Ordena los productos por precio de mayor a menor.
Campos válidos para ordenar:

id_producto

nombre_producto

precio_producto

fk_id_categoria
Filtrar por categoría

Permite obtener todos los productos pertenecientes a una categoría específica:

Verbo	URI	Ejemplo
GET	/api/categories/:id/products	/api/categories/2/products

Ejemplos de uso
🟢 Obtener todos los productos
GET http://localhost/practicoapi/api/products

🟢 Obtener productos ordenados por nombre (ascendente)
GET http://localhost/practicoapi/api/products?sort=nombre_producto&order=ASC

🟢 Obtener productos ordenados por precio (descendente)
GET http://localhost/practicoapi/api/products?sort=precio_producto&order=DESC

🟢 Obtener producto por ID
GET http://localhost/practicoapi/api/products/3

🟢 Obtener productos de una categoría
GET http://localhost/practicoapi/api/categories/1/products

Eliminar un producto
Función	Verbo HTTP	URI
Eliminar un producto con un ID dado	DELETE	/api/products/:id

Ejemplo
DELETE http://localhost/practicoapi/api/products/10

Insertar un producto (POST)
Verbo	URI
POST	/api/products

Body(JSON):
{
    "nombre_producto": "Jabón en polvo",
    "descripcion_producto": "Jabón para lavar ropa 800g",
    "precio_producto": 1200.50,
    "fk_id_categoria": 1
}

Modificar un producto (PUT)
Verbo	URI
PUT	/api/products/:id

Body(JSON):
{
    "nombre_producto": "Jabón líquido",
    "descripcion_producto": "Limpieza profunda 1L",
    "precio_producto": 1500,
    "fk_id_categoria": 1
}

Estructura de la base de datos (DER)

Tablas principales:

producto
Campo	Tipo	Descripción
id_producto	INT (PK)	Identificador del producto
nombre_producto	VARCHAR	Nombre del producto
descripcion_producto	TEXT	Descripción del producto
precio_producto	DOUBLE	Precio del producto
fk_id_categoria	INT (FK)	Relación con la tabla categoria
