 document.addEventListener("DOMContentLoaded",function(){

    startApp();

 });

 function startApp(){
    searchByDate();
 }


 function searchByDate(){

    const dateInput = document.querySelector("#fecha");

    dateInput.addEventListener("input",function(e){
        
        //Obtenemos la fecha seleccionada
        const selectedDate = e.target.value;

        //redireccionamos al usuario
        //al no colocar una url en especifico con http (solo añadimos un query string ?date) se redirecciona a la url actual pero con el parametro añadido
        window.location = `?date=${selectedDate}`;
        
    })

   
 }


 