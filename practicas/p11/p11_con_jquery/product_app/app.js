// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

let edit = false;

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
    fetchProducts();
}

//Funcion de busqueda de productos
$(document).ready(function(){
    $('#product-result').hide();

    $('#search').keyup(function(e) {
        if($('#search').val()){
            let search = $('#search').val();
            $.ajax({
            url: 'backend/product-search.php?search='+search,
            type: 'GET',
            success: function(response) {
                let product = JSON.parse(response);
                let template = '';
                let tmeplate_dec = '';
                product.forEach(product => {
                    let descripcion = '';
                    descripcion += '<li>precio: '+product.precio+'</li>';
                    descripcion += '<li>unidades: '+product.unidades+'</li>';
                    descripcion += '<li>modelo: '+product.modelo+'</li>';
                    descripcion += '<li>marca: '+product.marca+'</li>';
                    descripcion += '<li>detalles: '+product.detalles+'</li>';

                    tmeplate_dec += `
                        <tr productId="${product.id}">
                            <td>${product.id}</td>
                            <td>${product.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;

                    template += `<li>${product.nombre}</li>`
                });
                $('#container').html(template);
                $('#products').html(tmeplate_dec);
                console.log(template);
                $('#product-result').show();
            }

        })
        }
        else{
            fetchProducts();
            $('#product-result').hide();
        }
    });

    $('#product-form').submit(function (e) {
        e.preventDefault();
    
        // Obtener el ID del producto (si está en modo edición)
        let id = $('#productId').val();
    
        // Crear el objeto JSON con los valores de los campos
        let baseJSON = {
            "precio": parseFloat($('#price').val()), // Precio (convertido a número)
            "unidades": parseInt($('#units').val()), // Unidades (convertido a número)
            "modelo": $('#model').val(), // Modelo
            "marca": $('#brand').val(), // Marca
            "detalles": "NA", // Detalles (puedes agregar un campo para esto si es necesario)
            "imagen": $('#image').val() // Imagen
        };
    
        // Agregar el nombre al JSON
        baseJSON['nombre'] = $('#name').val();
    
        // Convertir el objeto JSON a una cadena
        let productoJsonString = JSON.stringify(baseJSON, null, 2);
    
        // Validaciones
        let errores = [];
    
        if (!baseJSON.nombre) {
            errores.push("No hay nombre de producto");
        }
        if (baseJSON.nombre.length > 100) {
            errores.push("El nombre del producto no puede ser mayor a 100 caracteres");
        }
        if (!baseJSON.marca) {
            errores.push("No hay marca de producto");
        }
        if (!baseJSON.modelo) {
            errores.push("No hay modelo de producto");
        }
        if (baseJSON.modelo.length > 25) {
            errores.push("El modelo no puede ser mayor a 25 caracteres");
        }
        if (!baseJSON.precio) {
            errores.push("No hay precio de producto");
        }
        if (baseJSON.precio <= 99.99) {
            errores.push("El precio no puede ser menor a 99.99");
        }
        if (baseJSON.detalles.length > 250) {
            errores.push("Los detalles no pueden ser mayor a 250 caracteres");
        }
        if (!baseJSON.unidades) {
            errores.push("No hay unidades de producto");
        }
        if (baseJSON.unidades < 0) {
            errores.push("Las unidades no pueden ser menores a 0");
        }
        if (isNaN(baseJSON.precio)) {
            errores.push("El precio no es un número");
        }
        if (baseJSON.imagen == "") {
            baseJSON.imagen = "img/default.jpg";
        }
    
        // Si hay errores, mostrarlos y detener el envío
        if (errores.length > 0) {
            alert("Errores en el formulario:\n\n" + errores.join("\n"));
            return;
        }
    
        // Cambiar el texto del botón si es necesario
        $('button.btn-primary').text("Agregar Producto");
    
        // Envío con POST y JSON en el cuerpo
        let url = edit === false ? 'product-add.php' : 'product-edit.php';
        $.ajax({
            url: 'backend/' + url + '?id=' + id,
            type: 'POST', // Usamos POST
            contentType: 'application/json; charset=UTF-8', // Indicamos que enviamos JSON
            data: productoJsonString, // Enviamos el JSON como cadena en el cuerpo
            success: function (response) {
                console.log(response);
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $("#product-result").addClass("card my-4 d-block");
                $("#container").html(template_bar);
                fetchProducts();
                edit = false;
            },
            error: function (status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
            }
        });
    });
});

    function fetchProducts() {
        $.ajax({
        url: 'backend/product-list.php',
        type: 'GET',
        success: function(response) {
            console.log(response);
            let product = JSON.parse(response);
            let template = '';
            product.forEach(product => {
                let descripcion = `
                    <li>precio: ${product.precio}</li>
                    <li>unidades: ${product.unidades}</li>
                    <li>modelo: ${product.modelo}</li>
                    <li>marca: ${product.marca}</li>
                    <li>detalles: ${product.detalles}</li>
                `;
                template += `
                    <tr productId="${product.id}">
                        <td>${product.id}</td>
                        <td>
                            <a href="#" class="product-item">${product.nombre}</a>
                        </td>
                        <td><ul>${descripcion}</ul></td>
                        <td>
                            <button class="product-delete btn btn-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#products').html(template);
        },
        error: function(status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });

    $(document).on('click','.product-delete',function(){
        if(confirm('Quieres eliminarlo?')){
            let element = $(this)[0].parentElement.parentElement;
            let id = $(element).attr('productId')
            $.get('backend/product-delete.php',{id:id},function(response){
                fetchProducts();
            })
        }
    })

    $(document).on('click','.product-item',function(){
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        $('button.btn-primary').text("Modificar Producto");
        $.post('backend/product-single.php',{id},function(response){
            edit = true;
            const product = JSON.parse(response);
            $('#name').val(product.nombre);
            var baseJSON = {
                "precio": product.precio,
                "unidades": product.unidades,
                "modelo": product.modelo,
                "marca": product.marca,
                "detalles": product.detalles,
                "imagen": product.imagen
            };
            $('#productId').val(product.id);
            var JsonString = JSON.stringify(baseJSON,null,2);
            document.getElementById("description").value = JsonString;
        })
    })

}
