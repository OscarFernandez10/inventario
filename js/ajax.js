const formularios_ajax=document.querySelectorAll(".FormularioAjax");

 //15 COMO ENVIAR DATOS de FORMULARIOS con AJAX y JAVASCRIPT
function enviar_formulario_ajax(e){
    e.preventDefaul();

    let enviar=confirm("Quieres enviar el formulario");

    if(enviar==true){

        let date= new FormData(this);
        let method=this.getAtribute("method");
        let action=this.getAtribute("action");

        let encabezados= new Headers();

        let config={
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };

        fetch(action,config)
        .then(respuesta => respuesta.text())
        .then(respuesta =>{
            let contenedor=document.querySelector(".form-rest");
            contenedor.innerHTML = respuesta;
        })
    }
}

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit",enviar_formulario_ajax);
});