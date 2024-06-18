<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Producto</title>
    <link rel="stylesheet" href="./css/tailwind.css">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Agregar Producto</h2>
        <form id="productForm" action="" method="POST">
            <div class="mb-4">
                <label for="nombreProducto" class="block text-gray-700 text-sm font-bold mb-2">Nombre del Producto:</label>
                <input type="text" id="nombreProducto" name="nombreProducto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <span id="errorNombre" class="text-red-500 text-xs"></span>
            </div>
            <div class="mb-4">
                <label for="precioUnidad" class="block text-gray-700 text-sm font-bold mb-2">Precio por Unidad:</label>
                <input type="number" id="precioUnidad" name="precioUnidad" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <span id="errorPrecio" class="text-red-500 text-xs"></span>
            </div>
            <div class="mb-4">
                <label for="cantidadInventario" class="block text-gray-700 text-sm font-bold mb-2">Cantidad de Inventario:</label>
                <input type="number" id="cantidadInventario" name="cantidadInventario" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <span id="errorCantidad" class="text-red-500 text-xs"></span>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Agregar Producto</button>
            </div>
        </form>
        
        <?php
        // Inicializa el array asociativo de productos en sesión
        session_start();
        if (!isset($_SESSION['productos'])) {
            $_SESSION['productos'] = [];
        }

        // Función para agregar un producto al array
        function agregarProducto(&$productos, $nombre, $precio, $cantidad) {
            $productos[] = [
                "nombre" => $nombre,
                "precio" => $precio,
                "cantidad" => $cantidad,
                "valor_total" => $precio * $cantidad
            ];
        }

        // Validar y agregar el producto si se reciben datos del formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombreProducto'];
            $precio = $_POST['precioUnidad'];
            $cantidad = $_POST['cantidadInventario'];

            // Validación de los datos
            $errores = [];

            if (empty($nombre)) {
                $errores['nombre'] = "El nombre del producto es obligatorio.";
            }

            if (!is_numeric($precio) || $precio <= 0) {
                $errores['precio'] = "El precio por unidad debe ser un número mayor a 0.";
            }

            if (!is_numeric($cantidad) || $cantidad < 0) {
                $errores['cantidad'] = "La cantidad de inventario no puede ser negativa.";
            }

            // Si no hay errores, agregar el producto
            if (empty($errores)) {
                agregarProducto($_SESSION['productos'], $nombre, $precio, $cantidad);
                echo "<p style='color: green;'>Producto agregado correctamente.</p>";
            } else {
                // Mostrar los errores
                foreach ($errores as $error) {
                    echo "<p style='color: red;'>$error</p>";
                }
            }
        }
        ?>

        <h2 class="text-2xl font-bold mt-6 mb-4">Productos</h2>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-200">Nombre del Producto</th>
                    <th class="py-2 px-4 bg-gray-200">Precio por Unidad</th>
                    <th class="py-2 px-4 bg-gray-200">Cantidad de Inventario</th>
                    <th class="py-2 px-4 bg-gray-200">Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($_SESSION['productos'])) {
                    foreach ($_SESSION['productos'] as $producto) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>{$producto['nombre']}</td>";
                        echo "<td class='border px-4 py-2'>{$producto['precio']}</td>";
                        echo "<td class='border px-4 py-2'>{$producto['cantidad']}</td>";
                        echo "<td class='border px-4 py-2'>{$producto['valor_total']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='border px-4 py-2 text-center'>No hay productos agregados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="./js/validations.js"></script>
</body>
</html>
