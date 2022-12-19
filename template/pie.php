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

        //if lastPart is equal to admin_form_edition.php, admin_create_user.php then add active class to admin_edition_client
        //if lastPart is equal to admin_edit_ausen.php then add active class to admin_consultar
        //if lastPart is equal to admin_create_func.php then add active class to admin_agregar
        if (lastPart == 'admin_form_edition.php' || lastPart == 'admin_create_user.php' || lastPart == 'admin_edit_ausen.php' || lastPart == 'admin_create_func.php' || lastPart == 'admin_edit_func.php' || lastPart == 'admin_func_form_edition.php') {

            if (link == 'admin_edition_client.php' && lastPart == 'admin_form_edition.php' || link == 'admin_edition_client.php' && lastPart == 'admin_create_user.php') {
                item.classList.add('active');

            } else if(lastPart == 'admin_edit_ausen.php' && link == 'admin_consultar.php'){
                item.classList.add('active');

            }else if(lastPart == 'admin_create_func.php' && link == 'admin_agregar.php'){
                item.classList.add('active');

            } else if((lastPart == 'admin_edit_func.php' || lastPart == 'admin_func_form_edition.php') && link == 'admin_cargar.php'){
                item.classList.add('active');

            } else {
                item.classList.remove('active');
            }

        } else {
            if (link == lastPart) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        }
    });


</script>

</body>
</html>