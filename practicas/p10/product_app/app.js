// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png",
    "eliminado":0
  };

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

function buscarProducto(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var word = document.getElementById('word').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if (productos && productos.length > 0) {
                let template = ''; // Inicializa la plantilla fuera del bucle
            
                productos.forEach(producto => { // Itera sobre cada producto en el array
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
            
                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });
            
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+word);
}

function validarDatos(nombre,finalJSON){
    let errores = [];
    if(nombre > 100 || nombre == ""){
        errores.push("El nombre está vacío o es muy largo");
    }
    if(finalJSON.marca == ""){
        errores.push("La marca está vacía");
    }
    if(finalJSON.modelo == "" || finalJSON.modelo.length > 25){
        errores.push("El modelo está vacío o es muy largo");
    }
    if(finalJSON.precio == "" || isNaN(finalJSON.precio) || parseFloat(finalJSON.precio) < 99.99){
        errores.push("El precio está vacío, no es un número o es menor a 99.99");
    }
    if(finalJSON.detalles > 250){
        errores.push("Los detalles son muy largos");
    }
    if(finalJSON.unidades == "" || isNaN(finalJSON.unidades) || parseInt(finalJSON.unidades) < 0){
        errores.push("Las unidades están vacías, no es un número o es menor a 0");
    }
    if(finalJSON.imagen == ""){
        finalJSON.imagen = "img/default.jpg";
    }
    return errores;
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();
    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    var finalJSON = JSON.parse(productoJsonString);
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON,null,2);

    errores = validarDatos(document.getElementById('name').value,finalJSON);
    if(errores.length > 0){
        alert(errores.join("\n"));
        return;
    }

    else{
        // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
        var client = getXMLHttpRequest();
        client.open('POST', './backend/create.php', true);
        client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
        client.onreadystatechange = function () {
            // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
            if (client.readyState == 4 && client.status == 200) {
                console.log(client.responseText);
                
                try {
                    var response = JSON.parse(client.responseText);
                    
                    if (response.status === "success") {
                        window.alert("Producto agregado correctamente");
                    } else {
                        window.alert("Error al agregar el producto: " + response.message);
                    }
                } catch (e) {
                    window.alert("Error en la respuesta del servidor");
                    console.error("Error al parsear JSON:", e);
                }
            }
        };
        client.send(productoJsonString);
    }
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}