

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

// ==================================================================================================
// GENERADOR DE CONTRASEÑA BÁSICO

document.addEventListener('DOMContentLoaded', function() {
// Esta función se ejecutará después de que el DOM esté completamente cargado
// Agregar el evento 'click' al elemento con el id 'refrescarBasico'
document.getElementById("refrescarBasico").addEventListener("click", actualizarContrasena);


    function generarContrasena() {
    var letrasMayusculas = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var letrasMinusculas = "abcdefghijklmnopqrstuvwxyz";
    var numeros = "0123456789";
    var simbolos = "!@#$%^&*-_=+";
    

    // Asegurarse de incluir al menos un carácter de cada tipo
    var primeraSeccion = letrasMayusculas.charAt(Math.floor(Math.random() * letrasMayusculas.length));
    var segundaSeccion = letrasMinusculas.charAt(Math.floor(Math.random() * letrasMinusculas.length));
    var terceraSeccion = numeros.charAt(Math.floor(Math.random() * numeros.length));
    var cuartaSeccion = simbolos.charAt(Math.floor(Math.random() * simbolos.length));

    // Resto de la longitud de la contraseña después de incluir al menos un carácter de cada tipo
    var longitudRestante = 4;
    
    
    var caracteres = letrasMayusculas + letrasMinusculas + numeros + simbolos;
    var contrasena = primeraSeccion + segundaSeccion + terceraSeccion + cuartaSeccion;

    // Eliminar caracteres utilizados en las secciones previas para evitar repeticiones
    caracteres = caracteres.replace(primeraSeccion, '');
    caracteres = caracteres.replace(segundaSeccion, '');
    caracteres = caracteres.replace(terceraSeccion, '');
    caracteres = caracteres.replace(cuartaSeccion, '');

    // Generar el resto de la contraseña con caracteres aleatorios y sin repeticiones
    for (var i = 0; i < longitudRestante; i++) {
        var caracterAleatorio = caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        // Verificar si el nuevo carácter es una letra mayúscula o minúscula y si el último carácter generado también lo es
        if ((letrasMayusculas.includes(contrasena.slice(-1)) || letrasMinusculas.includes(contrasena.slice(-1))) &&
            (letrasMayusculas.includes(caracterAleatorio) || letrasMinusculas.includes(caracterAleatorio))) {
            // Si es así, elegir otro carácter aleatorio hasta que no sea una letra
            while (letrasMayusculas.includes(caracterAleatorio) || letrasMinusculas.includes(caracterAleatorio)) {
                caracterAleatorio = caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
        }
        contrasena += caracterAleatorio;
        // Eliminar el carácter utilizado para evitar repeticiones
        caracteres = caracteres.replace(caracterAleatorio, '');
    }

    return contrasena;
    }

// Función para manejar la generación de contraseña y la actualización del texto de la contraseña
    function actualizarContrasena() {
    var contrasenaGenerada = generarContrasena();
    var passwordText = document.getElementById("passwordText");
    // Actualizar solo el texto de la contraseña generada
    passwordText.textContent = contrasenaGenerada;
    }
});


// =============================================================================================
// GENERADOR DE CONTRASEÑA AVANZADO

document.addEventListener('DOMContentLoaded', function() {
// Esta función se ejecutará después de que el DOM esté completamente cargado
// Agregar el evento 'click' al elemento con el id 'refrescarBasico'
document.getElementById("refrescarAvanzado").addEventListener("click", actualizarContrasenaAvanzada);



function generarContrasenaAvanzada(){
    // Obtener el estado de las casillas y la longitud desde el DOM
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
    // Verificar si todas las casillas están desmarcadas
    if (!checkMayu && !checkMinu && !checkNum && !checkSign) {
       alert('¡ERROR! No puedes generar una contraseña vacía. ')
   }
    // Verificar si todas las casillas están desmarcadas
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
        longitud -= 4; // Restar 4 caracteres de la longitud total
    }
    
    // Construir los caracteres restantes basados en las casillas marcadas
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

    function actualizarContrasenaAvanzada() {
        var contrasenaGenerada = generarContrasenaAvanzada();
        var passwordText = document.getElementById("passwordText");
        // Actualizar solo el texto de la contraseña generada
        passwordText.textContent = contrasenaGenerada;
    }

});

// =============================================================================================
// FUNCIÓN PARA EL BOTON COPIAR
function copiarPortapapeles(){
const boton = document.querySelector(".btn_copiar");
const text = document.getElementById("passwordText");

const copiarBtn = async str => {
  try {
    await navigator.clipboard.writeText(str);
    alert("¡¡La contraseña fué copiada  correctamente!!");
  } catch (error) {
    console.log(error);
  }
};

boton.addEventListener("click", () => {
    copiarBtn(text.textContent);
})
}

