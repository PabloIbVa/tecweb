document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("formularioTenis").addEventListener("submit", checkForm);
});

function checkForm(event) {
    event.preventDefault(); // Evita que el formulario se envíe si hay errores
    
    const nombre = document.getElementById("form-name");
    const marca = document.getElementById("form-marca");
    const modelo = document.getElementById("form-model");
    const precio = document.getElementById("form-price");
    const detalles = document.getElementById("form-detail");
    const unidades = document.getElementById("form-cant");
    const imagen = document.getElementById("form-img");

    let isValid = true;

    // Limpiar mensajes de error previos
    document.querySelectorAll(".error-message").forEach(span => span.textContent = "");

    if (nombre.value.trim() === "" || nombre.value.length > 100) {
        document.getElementById("error-name").textContent = 'El nombre está vacío o es muy largo';
        isValid = false;
    }
    if (marca.value.trim() === "") {
        document.getElementById("error-marca").textContent = 'La marca está vacía';
        isValid = false;
    }
    if (modelo.value.trim() === "" || modelo.value.length > 25) {
        document.getElementById("error-model").textContent = 'El modelo está vacío o es muy largo';
        isValid = false;
    }
    if (precio.value.trim() === "" || isNaN(precio.value) || parseFloat(precio.value) < 99.99) {
        document.getElementById("error-price").textContent = 'El precio está vacío, no es un número o es menor a 99.99';
        isValid = false;
    }
    if (detalles.value.length > 250) {
        document.getElementById("error-detail").textContent = 'Los detalles son muy largos';
        isValid = false;
    }
    if (unidades.value.trim() === "" || isNaN(unidades.value) || parseInt(unidades.value) < 0) {
        document.getElementById("error-cant").textContent = 'Las unidades están vacías, no es un número o es menor a 0';
        isValid = false;
    }

    if (imagen.value.trim() === "") {
        imagen.value = "img/default.jpg";
    }

    if (isValid) {
        event.target.submit(); // Si el formulario es válido, se envía
    }
}