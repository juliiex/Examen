const inputBusqueda = document.getElementById('busqueda');
const tablaProductos = document.getElementById('tabla-productos');

let temporizador;

inputBusqueda.addEventListener('input', function () {

    clearTimeout(temporizador);

    temporizador = setTimeout(() => {

        buscarProductos(this.value);

    }, 300);

});


async function buscarProductos(texto) {

    try {

        const respuesta = await fetch(
            `/productos/buscar?q=${encodeURIComponent(texto)}`
        );

        if (!respuesta.ok) {
            throw new Error('Error al consultar los productos');
        }

        const productos = await respuesta.json();

        mostrarProductos(productos);

    } catch (error) {

        console.error(error);

        tablaProductos.innerHTML = `
            <tr>
                <td colspan="7">
                    Error al cargar los productos.
                </td>
            </tr>
        `;
    }
}


function mostrarProductos(productos) {

    if (productos.length === 0) {

        tablaProductos.innerHTML = `
            <tr>
                <td colspan="7">
                    No se encontraron productos.
                </td>
            </tr>
        `;

        return;
    }

    tablaProductos.innerHTML = productos.map(producto => {

        return `
            <tr>

                <td>${producto.id}</td>

                <td>${producto.nombre}</td>

                <td>${producto.categoria.nombre}</td>

                <td>$${Number(producto.precio).toFixed(2)}</td>

                <td>${producto.stock}</td>

                <td>
                    ${producto.activo ? 'Sí' : 'No'}
                </td>

                <td>
                    <a href="/productos/${producto.id}/edit">
                        Editar
                    </a>
                </td>

            </tr>
        `;

    }).join('');
}
