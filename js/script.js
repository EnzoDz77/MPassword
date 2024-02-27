


// =================== VALIDACIONES======================
function validarLogin(){
    let nomUlo=document.getElementById("nomUser").value;
    let passLo = document.getElementById("pass").value;

    //Valido que los campos no esten vaciós
    if (  nomUlo === "" || passLo === "") {
        alert("¡¡USUARIO O CONTRASEÑA INCORRECTA!!");
        return false;
    }
}

// Validación de Registro 
function validarRegistro(){
    //Recogo los id de cada campo del formulario
    let nomU = document.getElementById("nomUserRegis").value;
    let email = document.getElementById("emailRegis").value;
    let pass1 = document.getElementById("passRegis1").value;
    let pass2 = document.getElementById("passRegis2").value;

    //Valido que los campos no esten vaciós
    if (  email === "" || nomU === "" || pass1 === "" || pass2 === "") {
    alert("¡¡No puedes dejar CAMPOS VACIOS!!");
    return false;
    }

    /* Validacion del campo email ,
    Hago la validacion mediante una expresión regular*/
    if(!(/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(email))) {
        alert("El valor del campo correo, ¡NO ES CORRECTO!");
        return false;
    }
    
    /*Validacion del campo nombre usuario,
    indico ue el campo nomrbreusuario debe tener como mínimo 4 caracteres*/ 
    if(!/^.{4,}$/.test(nomU)){
        alert("¡¡El nombre de Usuario debe tener como mínimo 4 caracteres.!!")
        return false;
    }

    /*Validacion de contraseña,
    indico ue la contraseña debe de tener mínimo 8 caracteres y tanto como el campo
    contraseña y confirmar contraseña deben ser las mismas*/
    if(!/^.{8,}$/.test(pass1)){
        alert("La contraseña debe tener mínimo 8 caracteres.")
        return false;
    }
    /*!== este simbolo es el no igual  que pero tambien nos permite controlar en el valor y el tipo*/
    else if(pass1!==pass2){
      alert("¡¡Las contraseñas deben ser las mismas!!");
      return false;
    }

    return true;
}
// =============================FIN DE LAS VALIDACIONES==============================================


// ==================================================================================================
// GENERADOR DE CONTRASEÑA BÁSICO

// Función se ejecutará después de que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {

// Agrego el evento 'click' al elemento con el id 'refrescarBasico'
document.getElementById("refrescarBasico").addEventListener("click", actualizarContrasena);

    // Creo la función para generar una contraseña aleatoria
    function generarContrasena() {
    let letrasMayusculas = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let letrasMinusculas = "abcdefghijklmnopqrstuvwxyz";
    let numeros = "0123456789";
    let simbolos = "!@#$%^&*-_=+";
    

    // Filtro para asegurar que al menos tenga un caracter de cada tipo en la contraseña 
    let primeraSeccion = letrasMayusculas.charAt(Math.floor(Math.random() * letrasMayusculas.length));
    let segundaSeccion = letrasMinusculas.charAt(Math.floor(Math.random() * letrasMinusculas.length));
    let terceraSeccion = numeros.charAt(Math.floor(Math.random() * numeros.length));
    let cuartaSeccion = simbolos.charAt(Math.floor(Math.random() * simbolos.length));

    // Resto de la longitud de la contraseña despues de incluir al menos un caracter de cada tipo
    let longitudRestante = 4;
    
    
    let caracteres = letrasMayusculas + letrasMinusculas + numeros + simbolos;
    let contrasena = primeraSeccion + segundaSeccion + terceraSeccion + cuartaSeccion;

    // Elimino caracteres utilizados para no repetir
    caracteres = caracteres.replace(primeraSeccion, '');
    caracteres = caracteres.replace(segundaSeccion, '');
    caracteres = caracteres.replace(terceraSeccion, '');
    caracteres = caracteres.replace(cuartaSeccion, '');

    // Generar el resto de la contraseña con caracteres aleatorios y sin repeticiones
    for (let i = 0; i < longitudRestante; i++) {
        let caracterAleatorio = caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        // Verificar si el nuevo caracter es una letra mayuscula o minuscula y si el ultimo caracter generado tambien lo es
        if ((letrasMayusculas.includes(contrasena.slice(-1)) || letrasMinusculas.includes(contrasena.slice(-1))) &&
            (letrasMayusculas.includes(caracterAleatorio) || letrasMinusculas.includes(caracterAleatorio))) {
            // Si es asi, elegir otro caracter aleatorio hasta que no sea una letra
            while (letrasMayusculas.includes(caracterAleatorio) || letrasMinusculas.includes(caracterAleatorio)) {
                caracterAleatorio = caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
        }
        contrasena += caracterAleatorio;
        // Eliminar el caracter a utilizar para evitar repeticiones
        caracteres = caracteres.replace(caracterAleatorio, '');
    }

    // Retorno la contraseña generada
    return contrasena;
    }

// Funcion para actualizar la contraseña generada
    function actualizarContrasena() {
    let contrasenaGenerada = generarContrasena();
    let passwordText = document.getElementById("passwordText");
    // Actualizo el texto por la contraseña generada
    passwordText.textContent = contrasenaGenerada;
    }
});


// =============================================================================================
// GENERADOR DE CONTRASEÑA AVANZADO

// Función se ejecutará después de que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {

// Agrego el evento 'click' al elemento con el id 'refrescarAvanzado'
document.getElementById("refrescarAvanzado").addEventListener("click", actualizarContrasenaAvanzada);

function generarContrasenaAvanzada(){
    // En esta apartado tambien tengo ue obtener la longitud de contraseña
    let checkMayu = document.getElementById("mayusculas").checked;
    let checkMinu = document.getElementById("minusculas").checked;
    let checkNum = document.getElementById("numeros").checked;
    let checkSign = document.getElementById("signos").checked;
    let longitud = parseInt(document.getElementById("longitud").value);
    
    let letrasMayusculas = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let letrasMinusculas = "abcdefghijklmnopqrstuvwxyz";
    let numeros = "0123456789";
    let simbolos = "!@#$%^&*-_=+";
    
    let contrasena = '';
    let caracteresRestantes = '';
    // Verifico si todas las casillas estan desmarcadas y muestro menasje de error.
    if (!checkMayu && !checkMinu && !checkNum && !checkSign) {
       alert('¡ERROR! No puedes generar una contraseña vacía. ')
    }
    // Despues de mostrar el alert automatico se marcara una casilla aleatoria
    if (!checkMayu && !checkMinu && !checkNum && !checkSign) {
        // Marcar una casilla aleatoria por defecto
        const checkboxes = ["mayusculas", "minusculas", "numeros", "signos"];
        const randomCheckbox = checkboxes[Math.floor(Math.random() * checkboxes.length)];
        document.getElementById(randomCheckbox).checked = true;
    }
    
    // Agregar al menos un carácter de cada propiedad si todas las casillas están marcadas
    if (checkMayu && checkMinu && checkNum && checkSign) {
        contrasena += letrasMayusculas.charAt(Math.floor(Math.random() * letrasMayusculas.length));
        contrasena += letrasMinusculas.charAt(Math.floor(Math.random() * letrasMinusculas.length));
        contrasena += numeros.charAt(Math.floor(Math.random() * numeros.length));
        contrasena += simbolos.charAt(Math.floor(Math.random() * simbolos.length));
        longitud -= 4; // Restar 4 caracteres de la longitud total.
    }
    
    // Despedieno ue casillas esten marcadas estos se añadira a al contraseña 
    if (checkMayu) caracteresRestantes += letrasMayusculas;
    if (checkMinu) caracteresRestantes += letrasMinusculas;
    if (checkNum) caracteresRestantes += numeros;
    if (checkSign) caracteresRestantes += simbolos;
    
    // Completar la longitud restante con caracteres aleatorios
    for (let i = 0; i < longitud; i++) {
        contrasena += caracteresRestantes.charAt(Math.floor(Math.random() * caracteresRestantes.length));
    }
    
    // Mezclar los caracteres de la contraseña para mayor aleatoriedad
    contrasena = contrasena.split('').sort(function(){return 0.5-Math.random()}).join('');
    
    return contrasena;
   }
    // Funcion para actualizar la contraseña generada
    function actualizarContrasenaAvanzada() {
        let contrasenaGenerada = generarContrasenaAvanzada();
        let passwordText = document.getElementById("passwordText");
        // Actualizo el texto por la contraseña generada
        passwordText.textContent = contrasenaGenerada;
    }

});


// Me ejecutela función cuando el dom esta completamente cargado
document.addEventListener('DOMContentLoaded', function() {
// FUNCIÓN PARA LA ANIMACIÓN DEL ESTADO DE CONTRASEÑA
function actualizarEstadoContraseña() {
    const longitudContraseña = document.getElementById('longitud');
    const estadoContraseñaV = document.querySelector('.estadoContraseña');
  
    longitudContraseña.addEventListener('input', function() {
      if (this.value >= 15) {
        estadoContraseñaV.textContent = 'Muy Segura';
        estadoContraseñaV.classList.remove('segura');
        estadoContraseñaV.classList.add('muySegura');
      } else if (this.value >= 12) {
        estadoContraseñaV.textContent = 'Segura';
        estadoContraseñaV.classList.remove('muySegura');
        estadoContraseñaV.classList.add('segura');
      } else {
        estadoContraseñaV.textContent = 'Buena';
        estadoContraseñaV.classList.remove('segura', 'muySegura');
      }
    });
  }
    //Llamado a la función
    actualizarEstadoContraseña();
});


// =============================================================================================
// FUNCIÓN PARA EL BOTON COPIAR
$(document).on("click", ".btn_copiar", function () {
    const text = $("#passwordText");

    if (text.length > 0) {
        var contrasena = text.text();
        var textarea = $("<textarea>").val(contrasena).appendTo("body").select();
        document.execCommand("copy");
        textarea.remove();
        alert("¡La contraseña fue copiada correctamente!");
    }
});



// Función para guardar la contraseña primero pasara por este filtro de javascript
// donde los datos se enviaran a procesa.php en ese archivo tengo toda la lógica para almacenar la contraseña 
// del usuario en al base de datos.
function guardarContraseña(event) {
    event.preventDefault(); // Evita que el formulario se envíe

    let password = document.getElementById("passwordText").innerText;
    let formData = new FormData();
    formData.append('password', password);

    let xhr = new XMLHttpRequest();
    xhr.open('POST', './php/procesa.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert('Contraseña guardada con éxito!');
        } else {
            alert('=>Error al guardar la contraseña');
        }
    };
    xhr.send(formData);
}