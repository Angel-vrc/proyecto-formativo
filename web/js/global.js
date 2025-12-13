$(document).ready(function() {

    $(document).on("keyup","#filtro",function(){
        
        let data = $(this).val();
        let url = $(this).data("url");


        $.ajax({
            url: url,
            type: "GET",
            data: {
                buscar: data
            },
            success: function(data){
                $("tbody").html(data);
            }
        })

    });


});

function cargarPermisosRol(idRol) {

    $.ajax({
        url: '/proyectoformativo/web/ajax.php',
        type: 'GET',
        data: {
            accion: 'getPermisosRoles',
            id_rol: idRol
        },
        success: function (html) {
            console.log(idRol);
            $('#contenedorPermisos').html(html);
        },
    });

}