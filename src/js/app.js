let step = 1;
const firstStep = 1;
const lastStep = 3;

const appointment = {

    id: "",
    nombre: "",
    fecha: "",
    hora: "",
    servicios: []

}

document.addEventListener("DOMContentLoaded",function(){

    startApp();

});


function startApp(){

    viewSection(); //Muestra y oculta secciones, se llama una vez para mostrar la primera sección
    tabs(); //Cambia la sección cuando se presionan los tabs
    paginationButtons(); //Agrega o quita los botones del paginador
    previousPage();
    nextPage();

    consultarAPI(); //Consulta la API en el backend de PHP
    
    customerId(); //Añade el id (que identifica al cliente en la BD) del cliente al objeto de appointment
    customerName(); //Añade el nombre del cliente al objeto de appointment
    dateSelected(); //Añade el fecha de la cita del cliente al objeto de appointment
    timeSelected(); //Añade la hora de la cita del cliente al objeto de appointment
    showSummary(); //Muestra le resumen de la cita 

}

function viewSection(){

    //Ocultar la sección que tenga la clase de view
    const previousSection = document.querySelector(".view");
    if(previousSection) previousSection.classList.remove("view");
       
    //Seleccionar la seccion con el paso
    const stepSelector = `#step-${step}`; 
    const section = document.querySelector(stepSelector);
    section.classList.add("view");

    //Quitar la clase: actual al tab (button) anterior
    const previousButton = document.querySelector(".actual");
    if(previousButton) previousButton.classList.remove("actual");

    //Resaltar el tab actual
    const buttonSelector = `[data-step="${step}"]`;
    const button = document.querySelector(buttonSelector);
    button.classList.add("actual");

}

function tabs(){

    const buttons = document.querySelectorAll(".tabs button");

    buttons.forEach( button => {
      button.addEventListener("click",function(e){
        step = parseInt(e.target.dataset.step);
    
        viewSection();
        paginationButtons();

      });  
    });


}


function paginationButtons(){

    const previousPage = document.querySelector("#previous");
    const nextPage = document.querySelector("#next");


    if(step === 1){
        previousPage.classList.add("hide-page");
        nextPage.classList.remove("hide-page");
    }else if(step === 3){
        previousPage.classList.remove("hide-page");
        nextPage.classList.add("hide-page");

        //Al momento de presionar en el botón de resumen, verificar si el usuario ya lleno todos los datos necesarios
        showSummary();
    }else{
        previousPage.classList.remove("hide-page");
        nextPage.classList.remove("hide-page");
    }


    viewSection();



}

function previousPage(){

    const previousPage = document.querySelector("#previous");

    previousPage.addEventListener("click",function(){

        if(step <= firstStep) return;

        step--;

        paginationButtons();

    });

}

function nextPage(){

    const nextPage = document.querySelector("#next");

    nextPage.addEventListener("click",function(){

        if(step >= lastStep) return;

        step++;

        paginationButtons();

    });

}


async function consultarAPI(){

    try{
        const url = `${location.origin}/api/services`;
        const result = await fetch(url);
        const services = await result.json(); //Convertir a JSON la respuesta

        viewServices(services);
        
        //con el await, se espera hasta que se termine de ejecutar dicha línea para continuar con las siguientes líneas de código
        //Resto del código...

    }catch(error){ //Capturamos la excepción en caso de que haya algun error en la conexión a la API
        console.log(error);
    }

}

//Con la asincronia nos permite estar ejecutando una función y mientras dicha función se ejecuta podemos ejecutar otras funciones (que sigan en el flujo de funciones)


function viewServices(services){

    services.forEach(service => {
        
        const {id, nombre, precio} = service;

        //Scripting para mostrar los servicios
        const serviceName = document.createElement("P");
        serviceName.classList.add("service-name");
        serviceName.textContent = nombre;

        const servicePrice = document.createElement("P");
        servicePrice.classList.add("service-price");
        servicePrice.textContent = `$${precio}`;

        const serviceDiv = document.createElement("DIV");
        serviceDiv.classList.add("service");
        serviceDiv.dataset.idService = id;
        //(), No se colocan los parentesis de la función (serviceDiv.onclick = selectService(service)), ya que JS lo interpreta como una llamada en automatico
        //Para poder pasar parametros a una función, asociada a un elemento HTML mediante el evento click, se usa un callback
        //Las funciones callback, son funciones que se pasan por parámetro a otras funciones.
        serviceDiv.onclick = function(){
            selectService(service);
        } 


        serviceDiv.appendChild(serviceName);
        serviceDiv.appendChild(servicePrice);

        document.querySelector("#services").appendChild(serviceDiv);
        

    });

}


function selectService(service){

    //Extraemos el id del objeto appointment
    const {id} = service;

    //Extraemos los servicios del objeto appointment
    const {servicios} = appointment;

    //Obtenemos el elemento tag del servicio seleccionado
    const serviceDiv = document.querySelector(`[data-id-service="${id}"]`);

    //Comprobar si un servicio ya fue agregado  en los servicios del objeto appointment 
    if( servicios.some(addService => addService.id === id)){
        //Eliminar el servicio de servicios
        //usamos el método filter para eliminar dicho servicio del array
        appointment.servicios = servicios.filter(agregado => agregado.id !== id);
        

        serviceDiv.classList.remove("select");  
    }else{
        //Agregar el servicio

        //En servicios de appointment le asignamos, los servicios que ya se tenian almacenados previamente {servicios} y agregamos el nuevo servicio (service)
        //Si se desea mantener inmutable el objeto original, se puede utilizar la sintaxis de propagación ... y el operador de array [].
        appointment.servicios = [...servicios, service];
        
        serviceDiv.classList.add("select");  
    }

   // console.log(appointment)
    
}


function customerId(){

    appointment.id = document.querySelector("#id").value;

}


function customerName(){

    appointment.nombre = document.querySelector("#nombre").value;

}


function dateSelected(){

    //Elemento donde sera añadido la alerta, en caso de ser necesaro
    const form = document.querySelector(".form");

    //Seleccionamos el input con la fecha
    const date = document.querySelector("#fecha");

    //Añadimos el evento a la fecha paa almacenarla
    date.addEventListener("input",function(e){

        //Creamos un objeto de Date con la fecha capturada y obtenemos el día de la semana
        const day = new Date(e.target.value).getUTCDay();
        
        //0 = domingo, 6 = sábado
        if([6,0].includes(day)){
            //Se puede usar el evento (e) o la variable date 
            e.target.value = "";
            //date.value = "";
            viewAlert("Fines de semana no permitidos","error",form);        
        }else{ //fecha correcta
            appointment.fecha = date.value;
        }


    });
}


function timeSelected(){

     const form = document.querySelector(".form");

     //Seleccionamos el input con la hora
     const timeInput = document.querySelector("#hora");

     timeInput.addEventListener("input", function(e){
        
        const appointmentTime = e.target.value;
        const time = appointmentTime.split(":")[0];

        if(time < 10 || time > 18){
            e.target.value = "";
            viewAlert("Hora no válida","error",form);    
        }else{
            appointment.hora = appointmentTime;
        }

     });



}


function viewAlert(messsage, type, element, visibility = true){

    //Comprobar si existe una alerta previa
    const alertPrevious = element.querySelector(".alert");
    if(alertPrevious) return; 

    //Crear la alerta con scripting
    const alert = document.createElement("DIV");
    alert.textContent = messsage;
    alert.classList.add("alert");
    alert.classList.add(type);

    //Añadir la alerta al formulario (element)
    element.appendChild(alert);

    if(visibility){
        //Eliminar alerta despues de 3 segundos
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }

}


function showSummary(){

    const summary = document.querySelector(".summary-content");

    //Limpiar el contenido del resumen
    while(summary.firstChild){
        summary.removeChild(summary.firstChild);
    }

    //Accedemos a los valores de la propiedades del objeto appointment, para comprobar
    if(Object.values(appointment).includes("") || appointment.servicios.length === 0){
       viewAlert("Faltan datos de servicios, fecha u hora","error",summary,false);
       
       return;  
    }/*else{
        const alert = summary.querySelector(".alert");
        alert.remove(); 
    } */


    // Formatear el div de resumen

    //destructuring al appointment
    const {nombre,fecha,hora,servicios} = appointment;

    //Heading para servicios en resumen
    const headingServices = document.createElement("H3");
    headingServices.textContent = "Resumen de servicio(s)";

    summary.appendChild(headingServices);

    //Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const {id,nombre,precio} = servicio;
        const serviceContainer = document.createElement("DIV");
        serviceContainer.classList.add("service-container");
        
        const serviceText = document.createElement("P");
        serviceText.textContent = nombre;

        const servicePrice = document.createElement("P");
        servicePrice.innerHTML = `<span>Precio: </span> ${precio}`;

        serviceContainer.appendChild(serviceText);
        serviceContainer.appendChild(servicePrice);

        summary.appendChild(serviceContainer);
    });

    //Heading para cita en resumen
    const headingAppointment = document.createElement("H3");
    headingAppointment.textContent = "Resumen de cita";

    summary.appendChild(headingAppointment);

    const customerName = document.createElement("P");
    customerName.innerHTML = `<span>Nombre: </span> ${nombre}`;

    //Formatear la fecha en español
    const dateObj = new Date(fecha);  //Creamos un objeto de Date

    //Obtenemos dia, mes y año
    const month = dateObj.getMonth();
    const day = dateObj.getDate() + 2;
    const year = dateObj.getFullYear(); 

    //Creamos una instancia de date pero ahora con UTC, para adaptar la fecha de acuerdo a una geolocalización
    const dateUTC = new Date(Date.UTC(year,month,day));
    
    //Opciones para el formato
    const dateOptions = {weekday: "long",year: "numeric", month: "long",day: "numeric"};
    //Formatear fecha con el método toLocaleDateString
    const formatDate = dateUTC.toLocaleDateString("es-MX",dateOptions);

    const appointmentDate = document.createElement("P");
    appointmentDate.innerHTML = `<span>Fecha: </span> ${formatDate}`;

    const appointmentTime = document.createElement("P");
    appointmentTime.innerHTML = `<span>Hora: </span> ${hora} horas`;

    //Boton para crear una cita
    const buttonContainer = document.createElement("DIV");
    buttonContainer.classList.add("button-container");

    const bookButton = document.createElement("BUTTON");
    bookButton.classList.add("button");
    bookButton.textContent = "Reservar cita";
    bookButton.onclick = appointmentBook;

    buttonContainer.appendChild(bookButton);

    summary.appendChild(customerName);
    summary.appendChild(appointmentDate);
    summary.appendChild(appointmentTime);

    summary.appendChild(buttonContainer);

}

async function appointmentBook(){

    //Extraemos la info a enviar al servidor
    const {id,fecha,hora,servicios} = appointment;

    const idServicios = servicios.map(service => service.id);

    //Creamos un nuevo objeto de FormData, contendra la informacion que sera enviada al servidor
    const data = new FormData();

    //Agregamos información
    data.append("fecha",fecha);
    data.append("hora",hora);
    data.append("usuarioId",id);
    data.append("servicios",idServicios); //Los id de los servicios son manejados como cadenas "1,2,3"


    try{

        //Petición hacia la api
        const url = `${location.origin}/api/appointments`;

        //El segundo parametro es un objeto de configuración, obligatorio en consultas POST
        const request = await fetch (url, {
            method: "POST",
            body: data
        });

        const result = await request.json(); 
        //En caso de que no se logre llevar a cabo la petición (ya sea por un error de conexión al servidor, por ejemplo) usando fetch API 
        //con async await, en la variable request no se tendra una respuesta en caso de algun error (ya que no estamos usando promesas)
        //Para capturar ese error, en caso de falla en la conexión al server o error en la consuta SQL, 
        //se puede realizar mediante try catch y mostrar una alerta de error en el catch 

        console.log(result);
        //Si la cita fue almacenada correctamente en la BD
        if(result.resultado){
            //Mostramos la alerta de la libreria sweetalert2
            //EN realidad es una promesa
            Swal.fire({
                icon: 'success',
                title: 'Cita creada',
                text: 'Tu cita ha sido agendada correctamente',
                button: 'OK'
            }).then(() => {
                //Recargamos la página
                setTimeout(() => {
                    window.location.reload();
                },3000);
            })
        }
    
    } catch(error){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrio un error inesperado, no se logro agendar su cita',
          })
    }    
    //console.log([...data]);

}