<script>
    const list = document.querySelectorAll('.list');

    function activeLink() {
        list.forEach((item) =>
        item.classList.remove('active'));
        this.classList.add('active');
        //event.preventDefault();  // <--- prevent the default action, in this case is href
    }

    //añadir a cada elemento de la lista el evento click
    //list.forEach((item) => item.addEventListener('click',activeLink))

    //get the las part of the url, and delete what is before the .php
    var url = window.location.href;
    var lastPart = url.substr(url.lastIndexOf('/') + 1);
    lastPart = lastPart.substr(0, lastPart.lastIndexOf('.php') + 4);
    //console.log(lastPart);

    //add active class to the link that match with the url, and remove it from the others
    list.forEach((item) => {
        var link = item.querySelector('a').getAttribute('href');
        link = link.substr(link.lastIndexOf('/') + 1);

        if (lastPart == 'admin_form_edition.php' || lastPart == 'admin_create_user.php' || lastPart == 'admin_edit_ausen.php' || lastPart == 'admin_create_func.php' || lastPart == 'admin_func_form_edition.php') {

            if (link == 'admin_edition_client.php' && lastPart == 'admin_form_edition.php' || link == 'admin_edition_client.php' && lastPart == 'admin_create_user.php') {
                item.classList.add('active');

            } else if(lastPart == 'admin_edit_ausen.php' && link == 'admin_consultar.php'){
                item.classList.add('active');

            } else if((lastPart == 'admin_create_func.php' || lastPart == 'admin_func_form_edition.php') && link == 'admin_edit_func.php'){
                item.classList.add('active');

            } else {
                item.classList.remove('active');
            }

        } 
        else {
            //console.log(link);
            if (link == lastPart) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        }
    });

    /* 
     * @description: Descargar el pdf de ayuda
     */
    document.getElementById("ayuda_pdf").querySelector("a").addEventListener("click", function(event){
        event.preventDefault(); //evitar que el navegador siga el enlace
        var value = this.getAttribute("value");
        //console.log(value);

        fetch("../logic/descargarAyuda.php", {
            method: "POST",
            body: "tipo_usuario="+value,
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        })
        .then(res => res.json()) //recoge la respuesta json del servidor y lo transforma en un objeto javascript
        .then(response => {
            if(response.status === 'success'){
                let a = document.createElement('a');
                a.href = "data:application/pdf;base64,"+response.file_data;
                a.download = response.file_name;
                a.click(); //se simula un click para descargar el archivo
            }else{
                console.log(response.message);
            }
        })
        .catch(error => console.log(error));
    });
</script>

</body>
</html>