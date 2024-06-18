document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('productForm');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Previene el envío del formulario

        // Limpia mensajes de error anteriores
        document.getElementById("errorNombre").innerText = "";
        document.getElementById("errorPrecio").innerText = "";
        document.getElementById("errorCantidad").innerText = "";

        let isValid = true;

        // Validación del nombre del producto
        const nombre = document.getElementById("nombreProducto").value;
        if (!nombre) {
            document.getElementById("errorNombre").innerText = "El nombre del producto es obligatorio.";
            isValid = false;
        }

        // Validación del precio por unidad
        const precio = document.getElementById("precioUnidad").value;
        if (!precio || precio <= 0) {
            document.getElementById("errorPrecio").innerText = "El precio por unidad debe ser mayor a 0.";
            isValid = false;
        }

        // Validación de la cantidad de inventario
        const cantidad = document.getElementById("cantidadInventario").value;
        if (!cantidad || cantidad < 0) {
            document.getElementById("errorCantidad").innerText = "La cantidad de inventario no puede ser negativa.";
            isValid = false;
        }

        if (isValid) {
            form.submit();
        }
    });
});
