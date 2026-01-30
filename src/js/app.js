let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
  id: "",
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};
document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
});

function iniciarApp() {
  mostrarSeccion(); // Muestra y oculta las secciones
  tabs(); // Cambia la seccion cuando se presionan tabs
  botonesPaginador(); // Agrega o quita los botones del paginador

  paginaSiguiente();
  paginaAnterior();

  consultarAPI(); // Consulta los servicios de json

  idCliente();
  nombreCliente(); // Añade el nombre del cliente a la cita
  seleccionarFecha(); // Añade la fecha a la cita
  seleccionarHora(); // Añade la hora a la cita
}
function mostrarSeccion() {
  // Ocultar la seccion que tenga la clase de mostrar
  const seccionAnterior = document.querySelector(".mostrar");
  if (seccionAnterior) {
    seccionAnterior.classList.remove("mostrar");
  }

  // Seleccionar la seccion con el paso...
  const seccion = document.querySelector(`#paso-${paso}`);
  seccion.classList.add("mostrar");

  // Quita la clase de actual al tab anterior
  const tabAnterior = document.querySelector(".actual");
  if (tabAnterior) {
    tabAnterior.classList.remove("actual");
  }
  // Resalta el tab actual
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add("actual");
}

function tabs() {
  const botones = document.querySelectorAll(".tabs button");
  botones.forEach((boton) => {
    boton.addEventListener("click", function (evento) {
      paso = parseInt(evento.target.dataset.paso);
      mostrarSeccion();
      botonesPaginador();
    });
  });
}

function botonesPaginador() {
  const paginaAnterior = document.querySelector("#anterior");
  const paginaSiguiente = document.querySelector("#siguiente");

  if (paso === 1) {
    paginaAnterior.classList.add("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  } else if (paso === 3) {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.add("ocultar");
    mostrarResumen();
  } else {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  }
  mostrarSeccion();
}

function paginaAnterior() {
  const paginaAnterior = document.querySelector("#anterior");
  paginaAnterior.addEventListener("click", function () {
    if (paso <= pasoInicial) return;
    paso--;

    botonesPaginador();
  });
}

function paginaSiguiente() {
  const paginaSiguiente = document.querySelector("#siguiente");
  paginaSiguiente.addEventListener("click", function () {
    if (paso >= pasoFinal) return;
    paso++;

    botonesPaginador();
  });
}

async function consultarAPI() {
  try {
    const url = "/api/servicios";
    const resultado = await fetch(url);
    const servicios = await resultado.json();
    mostrarServicios(servicios);
  } catch (error) {
    console.log(error);
  }
}

function mostrarServicios(servicios) {
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;

    const nombreServicio = document.createElement("P");
    nombreServicio.classList.add("nombre-servicio");
    nombreServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.classList.add("precio-servicio");
    precioServicio.textContent = precio;

    const servicioDiv = document.createElement("DIV");
    servicioDiv.classList.add("servicio");
    servicioDiv.dataset.idServicio = id;

    servicioDiv.appendChild(nombreServicio);
    servicioDiv.appendChild(precioServicio);
    servicioDiv.onclick = function () {
      seleccionarServicio(servicio);
    };

    const servicios = document.querySelector("#servicios");
    servicios.appendChild(servicioDiv);
  });
}

function seleccionarServicio(servicio) {
  const { id } = servicio;
  const { servicios } = cita;
  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

  if (servicios.some((agregado) => agregado.id === id)) {
    // existe
    cita.servicios = servicios.filter((agregado) => agregado.id !== id);
    divServicio.classList.remove("seleccionado");
  } else {
    // no existe
    cita.servicios = [...servicios, servicio];
    divServicio.classList.add("seleccionado");
  }
}

function nombreCliente() {
  const nombre = document.querySelector("#nombre").value;
  cita.nombre = nombre;
}
function idCliente() {
  const id = document.querySelector("#id").value;
  cita.id = id;
}

function seleccionarFecha() {
  const inputFecha = document.querySelector("#fecha");

  inputFecha.addEventListener("input", function (evento) {
    const fecha = new Date(evento.target.value).getUTCDay();
    const fines = [6, 0]; // Los dias semanales: se toma como 1 el lunes, sabado 6 y domingo 0

    if (fines.includes(fecha)) {
      evento.target.value = "";
      mostrarAlerta("Fines de Semana Cerrado", "error", ".formulario");
    } else {
      cita.fecha = evento.target.value;
    }
  });
}
function seleccionarHora() {
  const inputHora = document.querySelector("#hora");

  inputHora.addEventListener("input", function (evento) {
    const hora = evento.target.value.split(":")[0];
    if (hora < 8 || hora >= 22) {
      mostrarAlerta("Abierto desde 9 a 21", "error", ".formulario");
      evento.target.value = "";
    } else {
      cita.hora = evento.target.value;
    }
  });
}

function mostrarAlerta(mensaje, tipo, elemento, desaperece = true) {
  const alertaPrevia = document.querySelector(".alerta");
  if (alertaPrevia) {
    alertaPrevia.remove();
  }
  const alerta = document.createElement("DIV");
  alerta.textContent = mensaje;
  alerta.classList.add("alerta");
  alerta.classList.add(tipo);

  const referencia = document.querySelector(elemento);
  referencia.appendChild(alerta);

  if (desaperece) {
    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }
}

function mostrarResumen() {
  const resumen = document.querySelector(".contenido-resumen");

  // Limpia el contenido del resumen
  while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
  }

  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta("Faltan Datos", "error", ".contenido-resumen", false);
    return;
  }

  const precioDiv = document.querySelector("#pago");
  if (precioDiv) {
    precioDiv.remove();
  }

  const { nombre, fecha, hora, servicios } = cita;
  let precio = 0;
  cita.servicios.forEach((elemento) => (precio += parseInt(elemento.precio)));

  const nombreResumen = document.createElement("P");
  const horarioDiv = document.createElement("DIV");
  horarioDiv.classList.add("contenedor-horario");
  const fechaResumen = document.createElement("P");
  const horaResumen = document.createElement("P");

  nombreResumen.innerHTML = `<span>Nombre:</span> ${nombre}`;

  // Formatear la fecha
  const fechaObj = new Date(fecha);
  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 2;
  const year = fechaObj.getFullYear();
  const fechaUTC = new Date(Date.UTC(year, mes, dia));

  const options = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  const fechaFormateada = fechaUTC.toLocaleDateString("es-AR", options);
  fechaResumen.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;
  horaResumen.innerHTML = `<span>Hora:</span> ${hora}`;
  horarioDiv.appendChild(fechaResumen);
  horarioDiv.appendChild(horaResumen);

  resumen.appendChild(nombreResumen);
  resumen.appendChild(horarioDiv);

  const headingServicios = document.createElement("H4");
  headingServicios.textContent = "Servicios";
  resumen.appendChild(headingServicios);
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;
    const contenedorServicio = document.createElement("DIV");
    contenedorServicio.classList.add("contenedor-servicios");

    const textoServicio = document.createElement("P");
    textoServicio.innerHTML = `${id} - ${nombre} - <span>Precio: $${precio}</span>`;
    contenedorServicio.appendChild(textoServicio);

    resumen.appendChild(contenedorServicio);
  });

  // Boton de reservar
  const botonReservar = document.createElement("BUTTON");
  botonReservar.textContent = "Reservar Cita";
  botonReservar.classList.add("boton");
  botonReservar.onclick = reservarCita;

  resumen.appendChild(botonReservar);
}

async function reservarCita() {
  const { id, fecha, hora, servicios } = cita;
  const idServicio = servicios.map((servicio) => servicio["id"]);
  const datos = new FormData();
  datos.append("usuario_id", id);
  datos.append("fecha", fecha);
  datos.append("hora", hora);
  datos.append("servicios", idServicio);
  // console.log([...datos]); Mostrar los datos de FormData

  try {
    // Peticion hacia la api

    /* 
    const url = `${location.origin}/api/citas`; 
    Detecta de donde se esta ejecutando y lo agrega

    const url = `/api/citas`; 
    Funciona cuando el backend y el front estan hospedados en el mismo dominio
    */
    const url = `/api/citas`;
    const respuesta = await fetch(url, {
      method: "POST",
      body: datos,
    });
    const resultado = await respuesta.json();

    if (resultado.resultado) {
      Swal.fire({
        icon: "success",
        title: "Cita creada",
        text: "Tu cita fue creada exitosamente",
        button: "OK",
      }).then(() => {
        setTimeout(() => {
          window.location.reload();
        }, 500);
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Hubo un error al crear  la cita!",
    });
  }
}
