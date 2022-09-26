function confirmacion(e){
    if (confirm("¿Estás seguro que desea eliminar este usuario?")){
        return true;

    }else{
        e.preventDefault();
    }
}

let linkDelete = document.querySelectorAll(".btn-delete");
for( var i =0; i < linkDelete.length; i++){

    linkDelete[i].addEventListener('click', confirmacion);
}