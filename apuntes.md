Cuando asociamos un evento de esta forma no podemos ponerle parentesis a la funcion "reservarCita".
De esta forma la funcion sera solicitada cuando ocurra el evento onclick. si se pusiera () la funcion seria ejecutada al momento de crear el boton.
```js
const botonReservar = document.createElement('BUTTON');
botonReservar.textContent = 'Reservar Cita';
botonReservar.classList.add('button');
botonReservar.onclick = reservarCita;
}

function  reservarCita() {
    console.log('Reservando cita...')
}
```
Pero, si queremos pasarle parametros podemos crear un call back
```js
const botonReservar = document.createElement('BUTTON');
botonReservar.onclick = function () {
    reservarCita(parametros);
}

function  reservarCita(parametros) {
    console.log('Reservando cita...')
}
```