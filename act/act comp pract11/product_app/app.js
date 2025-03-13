let edit = false;

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    document.getElementById("price").value = 0.0;
    document.getElementById("units").value = 0;
    document.getElementById("model").value = "NA";
    document.getElementById("brand").value = "NA";
    document.getElementById("image").value = "img/default.png";
    fetchProducts();
}

//Funcion de busqueda de productos
$(document).ready(function(){
    $('#product-result').hide();

    $('#name').keyup(function (e) {
        if ($('#name').val()) {
            let name = $('#name').val();
            $.ajax({
                url: 'backend/nombre.php?name=' + name,
                type: 'GET',
                success: function (response) {
                    console.log(response); // Ver la respuesta en la consola
                    if (response.existe) {
                        $('#name-error').text("Este nombre de producto ya existe.").show();
                    } else {
                        $('#name-error').text("").hide();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }
            });
        } else {
            $('#name-error').text("").hide();
        }
    });

    $('#search').keyup(function(e) {
        if($('#search').val()){
            let search = $('#search').val();
            $.ajax({
            url: 'backend/product-search.php?search='+search,
            type: 'GET',
            success: function(response) {
                let product = JSON.nparse(respose);
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

            // Asignar los valores del producto a los campos del formulario
            $('#name').val(product.nombre); // Nombre
            $('#price').val(product.precio); // Precio
            $('#units').val(product.unidades); // Unidades
            $('#model').val(product.modelo); // Modelo
            $('#brand').val(product.marca); // Marca
            $('#details').val(product.detalles);
            $('#image').val(product.imagen); // Imagen

            // Asignar el ID del producto al campo oculto
            $('#productId').val(product.id);
            })
    })
    
    $("#name").on("blur", validateName);
    $("#price").on("blur", validatePrice);
    $("#units").on("blur", validateUnits);
    $("#model").on("blur", validateModel);
    $("#brand").on("blur", validateBrand);
    $("#details").on("blur",validateDetail)

    function validateName() {
        const name = $("#name").val();
        const errorElement = $("#name-error");
        if (!name) {
            errorElement.text("No hay nombre producto").show();
            return false;
        } else if (name.length > 100) {
            errorElement.text("El nombre no puede tener más de 100 caracteres.").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validatePrice() {
        const price = parseFloat($("#price").val());
        const errorElement = $("#price-error");
        if (isNaN(price)) {
            errorElement.text("El precio debe ser un número.").show();
            return false;
        } else if (price <= 99.99) {
            errorElement.text("El precio no puede ser menor a 99.99.").show();
            return false;
        } else if(!price){
            errorElement.text("No hay precio de producto").show();
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validateUnits() {
        const units = parseInt($("#units").val());
        const errorElement = $("#units-error");
        if (isNaN(units)) {
            errorElement.text("Las unidades deben ser un número.").show();
            return false;
        } else if (units < 0) {
            errorElement.text("Las unidades no pueden ser menores a 0.").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validateModel(){
        const model = $("#model").val();
        const errorElement = $("#model-error");
        if(!model){
            errorElement.text("No hay modelo de producto").show();
            return false;
        } else if (model.length > 25 ){
            errorElement.text("El modelo no puede ser mayor a 25 caracteres").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validateBrand(){
        const brand = $("#brand").val();
        const errorElement = $("#brand-error");
        if(!brand){
            errorElement.text("No hay marca del producto").show();
            return false;
        } else if (brand.length > 25 ){
            errorElement.text("El modelo no puede ser mayor a 25 caracteres").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }

    function validateDetail(){
        const details = $("#details").val();
        const errorElement = $("#details-error");
        if(details.length > 250){
            errorElement.text("Los detalles no pueden ser mayor a 250 caracteres").show();
            return false;
        } else {
            errorElement.text("").hide();
            return true;
        }
    }
}
