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
                url: 'backend/product-search.php?search=' + search,
                type: 'GET',
                success: function(response) {
                    let products = response; // jQuery ya parsea el JSON
                    let template = '';
                    let template_dec = '';
                    
                    products.forEach(product => {
                        // Lista de nombres en el cuadro blanco
                        template += `<li>${product.nombre}</li>`;
                        
                        // Filas de la tabla
                        let descripcion = `
                            <li>Precio: ${product.precio}</li>
                            <li>Unidades: ${product.unidades}</li>
                            <li>Modelo: ${product.modelo}</li>
                            <li>Marca: ${product.marca}</li>
                            <li>Detalles: ${product.detalles}</li>
                        `;

                        template_dec += `
                            <tr productId="${product.id}">
                                <td>${product.id}</td>
                                <td>${product.nombre}</td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    $('#container').html(template);
                    $('#products').html(template_dec);
                    $('#product-result').show();
                }
            });
        } else {
            // Si el campo está vacío, recargar todos los productos
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
            "precio": parseFloat($('#price').val()),
            "unidades": parseInt($('#units').val()),
            "modelo": $('#model').val(),
            "marca": $('#brand').val(),
            "detalles": $('#details').val() || "NA", // Campo detalles desde el formulario
            "imagen": $('#image').val()
        };
    
        // Agregar el nombre al JSON
        baseJSON['nombre'] = $('#name').val();
    
        // Añadir ID al JSON si está en modo edición
        if (edit) {
            baseJSON['id'] = id;
        }
    
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
    
        // Cambiar el texto del botón
        $('button.btn-primary').text(edit ? "Modificar Producto" : "Agregar Producto");
    
        // Envío con POST y JSON en el cuerpo
        let url = edit ? 'product-edit.php' : 'product-add.php'; // URL dinámica
        $.ajax({
            url: 'backend/' + url,
            type: 'POST',
            contentType: 'application/json; charset=UTF-8',
            data: JSON.stringify(baseJSON), // Enviar todo el JSON
            success: function (response) {
                console.log("Respuesta del servidor:", response);
                
                // Si la respuesta es un string, parsearla; si no, usarla directamente
                let respuesta = typeof response === 'string' ? JSON.parse(response) : response;
                
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                $("#product-result").addClass("card my-4 d-block");
                $("#container").html(template_bar);
                fetchProducts();
                edit = false;
                $('#product-form')[0].reset();
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error);
                alert("Error al procesar la solicitud. Ver consola para detalles.");
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
        let element = $(this).closest('tr');
        let id = $(element).attr('productId');
        $('button.btn-primary').text("Modificar Producto");
        
        $.post('backend/product-single.php',{id: id}, function(response){
            try {
                let product = response;
                if (Object.keys(product).length > 0) { // Validar que no esté vacío
                    $('#name').val(product.nombre);
                    $('#price').val(product.precio);
                    $('#units').val(product.unidades);
                    $('#model').val(product.modelo);
                    $('#brand').val(product.marca);
                    $('#details').val(product.detalles);
                    $('#image').val(product.imagenes);
                    $('#productId').val(product.id);
                    edit = true;
                } else {
                    alert("Producto no encontrado");
                }
            } catch(e) {
                console.error("Error al parsear respuesta:", response);
            }
        });
    });
    
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
