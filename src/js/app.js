let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

//Objeto 
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    mostrarSeccion(); // Muestra y oculta las secciones de los Tabs
    tabs(); // Cambia la seccion cuando se presionen los tabs button
    botonesPaginador(); // Agrega o quita los botones del paginador
    paginaSiguiente(); // Pagina siguiente
    paginaAnterior(); // Pagina siguiente

    consultarAPI(); // Consulta la API el backend de PHP

    idCliente();
    nombreCliente(); // Añade el nombre del cliente al objeto  cita
    
    seleccionarFecha(); // añade la fecha de la cita en el objeto cita
    seleccionarHora(); // añade la hora de la cita al obeto cita
    mostrarResumen(); // Muestra el resumen de la cita antes de recervar


}

function mostrarSeccion(){

    // Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    // Selecciona la seccion en el paso...
    const pasoSelector = `#paso-${paso}`
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');


    // Quita la clase actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior){
        tabAnterior.classList.remove('actual');
    }


    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');

}

function tabs(){
    const botones = document.querySelectorAll('.tabs button'); // Permite la iteraccion cuando
    // tenemos varios selectores pero debemos iterar por cada uno por un foreach para dar un addEventListener para recorrer
    // y ver la funcion de todos
    botones.forEach( boton => {
        boton.addEventListener('click', (e)=>{
            paso = parseInt (e.target.dataset.paso);
            mostrarSeccion();

            botonesPaginador();
            // if (paso === 3) {
            //     mostrarResumen();
            // }
        });
    });     
}

function botonesPaginador(){

    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function() {
        if (paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    });
}
function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function() {
        if (paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    });
}

async function consultarAPI() {

    try {
        const url =  `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);


    } catch (error) {
        console.log(error);
    }
}
function mostrarServicios(servicios) {
    servicios.forEach( servicio => {
        const { id, nombre, precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent= nombre;


        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent= `$${precio}`;

        const servicioDIV = document.createElement('DIV');
        servicioDIV.classList.add('servicio');
        servicioDIV.dataset.idServicio = id;
        servicioDIV.onclick = function(){
            seleccionarServicio(servicio);
        }

        servicioDIV.appendChild(nombreServicio);
        servicioDIV.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDIV);

        console.log(servicioDIV);
    });
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    // Identifia el elemento al que se le da click en algun servicio o producto
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    //Comprobar si un producto o servicio ya fue agregado
    if (servicios.some( agregado =>  agregado.id === id ) ) {
        // Eliminarlo
        cita.servicios = servicios.filter( agregado => agregado.id !== id); //filter es un tipo de array method que permite sacar baso en alguna condicion
        divServicio.classList.remove('seleccionado');
    } else {
        // AGREGA
        cita.servicios = [...servicios, servicio]; //Agrega el servicio y el nuevo servicio como copia en memoria de el arreglo de servicios
        
        divServicio.classList.add('seleccionado');
    }
    console.log(cita);
}

function idCliente(){
    cita.id = document.querySelector('#id').value;
}

function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e) {
        //console.log(e.target.value); //Restringir solo dias que se de reservaciones a la cita 0= Domingo 1= Lunes, 2=Martes, 3= Miercoles, 4= Jueves, 5=Viernes, 6=Sabado
        const dia = new Date(e.target.value).getUTCDay(); // con getUTCDay obtenemos el día de la semana dentro de un calendario de tipo date
        if ([6,0].includes(dia)) { // Restringimos los días que se laboran - El método includes() determina si una matriz incluye un determinado elemento, devuelve true o false según corresponda.
            e.target.value = '';
            // console.log('Sábado y Domingo no se labora');
            mostrarAlerta('Fines de Semana no se Labora', 'error', '.formulario');
        } else{
            cita.fecha = e.target.value;
        }
    });
}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        // console.log(e.target.value);
        const horaCita = e.target.value
        const hora = horaCita.split(":")[0];
        //Metemos condicion sobre la hora que se abre y cierra dependiendo de la hora
        if (hora <  10 || hora > 20) {
            e.target.value = '';
            mostrarAlerta('Hora no Valida, debe ser de 10:00 AM a 20:00 PM', 'error', '.formulario')
        } else {
            cita.hora = e.target.value;
            console.log(cita);
        }

    });

}

function mostrarAlerta(mensaje, tipoAlerta, elemento, desaparece = true) {

    // Prevenimos que se genere más de una alerta pulsando los días no permitidos
    const alertaPrevia = document.querySelector('.alerta'); 
    if (alertaPrevia) {
        alertaPrevia.remove();
    }


    // Scrip para generar la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipoAlerta);

    const referencia = document.querySelector(elemento); //Se indica en donde se desea que se coloque la alerta aqui es arriba del formulario
    referencia.appendChild(alerta);

    if (desaparece) {
            // Indicamos el tiempo que dura la alerta y la elimina
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }

   
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    resumen.innerHTML = '';
    // Limpiar contenido de Resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora', 'error', '.contenido-resumen', false)

        return;
    } 
    
    // FORMATEAR EL DIV DE RESUMEN

    const { nombre, fecha, hora, servicios } = cita;

    // Heading para Servicios en Resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    //Iterando en los servicios para que se muestran el el contenedor de servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

     // Heading para Cita en Resumen
     const  headingCita = document.createElement('H3');
     headingCita.textContent = 'Resumen de Cita';
     resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span>${nombre}`;


    //Formatear la fecha en español

    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date( Date.UTC(year, mes, dia));
    // console.log(fechaUTC);
    const opciones = {day: 'numeric', weekday: 'long', month: 'long',  year: 'numeric'  }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);
    //console.log(fechaFormateada);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span>${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span>${hora} Horas`;

    // Boton para crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';

    botonReservar.onclick = reservarCita;


    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);
}

//Fetch API 
async function reservarCita() {
    
    const { nombre, fecha, hora, servicios, id } = cita;

    const idServicios = servicios.map( servicio => servicio.id );
    // console.log(idServicios);
    // return;

    const datos = new FormData();
    //Agregamos datos
   
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    // console.log([...datos]);

    // return;

    try {
         //Peticion hacia la API
        const url =  `${location.origin}/api/citas;`
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });

        const resultado = await respuesta.json();
        console.log(resultado.resultado);

        if (resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita Creada",
                text: "La cita esta Reservada",
                button: 'OK'
            }).then(() =>{
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
               
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un Error al Reservar la Cita"
          });
    }
   


    // console.log(respuesta);
    //console.log([...datos]);

}
