function getDatos()
{
    var nombre = prompt("Nombre: ", "");

    var edad = prompt("Edad: ", 0);

    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3> Nombre: '+nombre+'</h3>';

    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3> Edad: '+edad+'</h3>';
}

//JS01_Introduccion_a_JavaScript.pdf
//Ejemplo pág. 8
function mostrarMensaje() {
    document.write('Hola Mundo');
}

//JS02_Variables_Entradas_Operadores.pdf
//Ejemplo pág. 6
function mostrarDatos() {
    var nombre = 'Juan';
    var edad = 10;
    var altura = 1.92;
    var casado = false;

    document.getElementById("MD").innerHTML = `${nombre}<br>${edad}<br>${altura}<br>${casado}`;
}

//Ejemplo pág. 12 
function solicitarDatos() {
    var nombre = prompt('Ingresa tu nombre:', '');
    var edad = prompt('Ingresa tu edad:', '');

    if (nombre && edad) {
        document.getElementById("SD").innerHTML = `Hola ${nombre}, así que tienes ${edad} años.`;
    } else {
        document.getElementById("SD").innerHTML = 'Por favor, ingresa todos los datos.';
    }
}

//JS03_Estructuras_de_condicion.pdf
//Ejemplo pág. 3
function calcularOperaciones() {
    var valor1 = prompt('Introducir primer número:', '');
    var valor2 = prompt('Introducir segundo número:', '');

    if (!isNaN(valor1) && !isNaN(valor2) && valor1 !== '' && valor2 !== '') {
        var suma = +valor1 + +valor2;
        var producto = +valor1 * +valor2;

        document.getElementById("CO").innerHTML = `La suma es ${suma}<br>El producto es ${producto}`;
    } else {
        document.getElementById("CO").innerHTML = 'Por favor, ingresa valores numéricos válidos.';
    }
}

//Ejemplo pág. 8
function verificarAprobacion() {
    var nombre = prompt('Ingresa tu nombre:', '');
    var nota = prompt('Ingresa tu nota:', '');

    if (!isNaN(nota) && nota !== '') {
        var notaNum = parseFloat(nota);

        document.getElementById("VA").innerHTML = `${nombre} ${notaNum >= 4 ? 'está aprobado' : 'no ha aprobado'} con un ${notaNum}`;
    } else {
        document.getElementById("VA").innerHTML = 'Por favor, ingresa una nota válida.';
    }
}

//Ejemplo pág. 11
function encontrarMayor() {
    var num1 = prompt('Ingresa el primer número:', '');
    var num2 = prompt('Ingresa el segundo número:', '');

    if (!isNaN(num1) && !isNaN(num2) && num1 !== '' && num2 !== '') {
        var num1Int = +num1;
        var num2Int = +num2;

        if (num1Int > num2Int) {
            document.getElementById("EM").innerHTML = `El mayor es ${num1Int}`;
        } else if (num2Int > num1Int) {
            document.getElementById("EM").innerHTML = `El mayor es ${num2Int}`;
        } else {
            document.getElementById("EM").innerHTML = 'Ambos números son iguales.';
        }
    } else {
        document.getElementById("EM").innerHTML = 'Por favor, ingresa valores numéricos válidos.';
    }
}

//Ejemplo pág. 15-16
function calcularPromedio() {
    var nota1 = prompt('Ingresa 1ra. nota:', '');
    var nota2 = prompt('Ingresa 2da. nota:', '');
    var nota3 = prompt('Ingresa 3ra. nota:', '');

    if (!isNaN(nota1) && !isNaN(nota2) && !isNaN(nota3) && nota1 !== '' && nota2 !== '' && nota3 !== '') {
        var promedio = (+nota1 + +nota2 + +nota3) / 3;
        var mensaje = '';

        if (promedio >= 7) {
            mensaje = 'Aprobado';
        } else if (promedio >= 4) {
            mensaje = 'Regular';
        } else {
            mensaje = 'Reprobado';
        }

        document.getElementById("CP").innerHTML = `Promedio: ${promedio.toFixed(2)} - ${mensaje}`;
    } else {
        document.getElementById("CP").innerHTML = 'Por favor, ingresa valores numéricos válidos.';
    }
}

//Ejemplo pág. 18
function convertirNumeroATexto() {
    var valor = prompt('Ingresar un valor comprendido entre 1 y 5:', '');

    if (!isNaN(valor) && valor !== '') {
        var valorInt = +valor;
        var mensaje = '';

        switch (valorInt) {
            case 1: mensaje = 'Uno'; break;
            case 2: mensaje = 'Dos'; break;
            case 3: mensaje = 'Tres'; break;
            case 4: mensaje = 'Cuatro'; break;
            case 5: mensaje = 'Cinco'; break;
            default: mensaje = 'Debe ingresar un valor comprendido entre 1 y 5.';
        }

        document.getElementById("CN").innerHTML = mensaje;
    } else {
        document.getElementById("CN").innerHTML = 'Por favor, ingresa un número válido.';
    }
}

//Ejemplo pág. 21
function cambiarColorFondo() {
    var col = prompt('Ingresa el color con que quieres pintar el fondo de la ventana (rojo, verde, azul):', '').toLowerCase();

    switch (col) {
        case 'rojo': document.body.style.backgroundColor = '#ff0000'; break;
        case 'verde': document.body.style.backgroundColor = '#00ff00'; break;
        case 'azul': document.body.style.backgroundColor = '#0000ff'; break;
        default: alert('Por favor, ingresa uno de los colores válidos: rojo, verde o azul.');
    }
}

//JS04_Estructuras_de_repeticion.pdf
//Ejemplo pág. 5
function mostrarNumeros() {
    var resultado = '';

    for (var x = 1; x <= 100; x++) {
        resultado += `${x}<br>`;
    }

    document.getElementById("MN").innerHTML = resultado;
}

//Ejemplo pág. 6
function calcularSuma() {
    var suma = 0;

    for (var x = 1; x <= 5; x++) {
        var valor = prompt('Ingresa el valor:', '');

        if (!isNaN(valor) && valor !== '') {
            suma += +valor;
        } else {
            alert('Por favor, ingresa un número válido.');
            x--; // Repetir la iteración si el valor no es válido
        }
    }

    document.getElementById("CS").innerHTML = `La suma de los valores es ${suma}`;
}

//Ejemplo pág. 12
function contarDigitos() {
    var resultado = '';

    while (true) {
        var valor = prompt('Ingresa un valor entre 0 y 999:', '');

        if (!isNaN(valor) && valor !== '') {
            var valorInt = +valor;

            if (valorInt === 0) break; // Termina el bucle si el usuario ingresa 0

            resultado += `El valor ${valorInt} tiene `;

            if (valorInt < 10) {
                resultado += '1 dígito';
            } else if (valorInt < 100) {
                resultado += '2 dígitos';
            } else {
                resultado += '3 dígitos';
            }

            resultado += '<br>';
        } else {
            alert('Por favor, ingresa un número válido entre 0 y 999.');
        }
    }

    document.getElementById("CD").innerHTML = resultado;
}

//Ejemplo pág. 16
function mostrarNumeros2() {
    var resultado = '';

    for (var f = 1; f <= 10; f++) {
        resultado += `${f} `;
    }

    document.getElementById("MosNum").innerHTML = resultado;
}

//JS05_Funciones.pdf
//Ejemplo pág. 6
function mostrarMensajes() {
    var mensajes = 'Cuidado<br>Ingresa tu documento correctamente<br>';
    var resultado = '';

    for (var i = 0; i < 3; i++) {
        resultado += mensajes;
    }

    document.getElementById("MosMen").innerHTML = resultado;
}

//Ejemplo pág. 7
function mostrarMensaje() {
    var mensaje = 'Cuidado<br>Ingresa tu documento correctamente<br>';
    document.getElementById("MosMen2").innerHTML += mensaje;
}

mostrarMensaje();
mostrarMensaje();
mostrarMensaje();

//Ejemplo pág. 10
function mostrarRango(x1, x2) {
    var resultado = '';

    for (var inicio = x1; inicio <= x2; inicio++) {
        resultado += `${inicio} `;
    }

    document.getElementById("MR").innerHTML = resultado;
}

var valor1 = +prompt('Ingresa el valor inferior:', '');
var valor2 = +prompt('Ingresa el valor superior:', '');
mostrarRango(valor1, valor2);

//Ejemplo pág. 13
function convertirCastellano(x) {
    switch (x) {
        case 1: return "uno";
        case 2: return "dos";
        case 3: return "tres";
        case 4: return "cuatro";
        case 5: return "cinco";
        default: return "valor incorrecto";
    }
}

var valor = +prompt("Ingresa un valor entre 1 y 5", "");
document.getElementById("CC").innerHTML = convertirCastellano(valor);

//Ejemplo pág. 15
function convertirCastellano2(x) {
    switch (x) {
        case 1: return "uno";
        case 2: return "dos";
        case 3: return "tres";
        case 4: return "cuatro";
        case 5: return "cinco";
        default: return "valor incorrecto";
    }
}

var valor2 = +prompt("Ingresa un valor entre 1 y 5", "");
document.getElementById("CC2").innerHTML = convertirCastellano2(valor2);