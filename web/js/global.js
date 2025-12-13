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

   $('#contenedorPermisos').html(
        "<p class='text-muted'>Cargando permisos...</p>"
    );

    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        dataType: 'json',
        data: {
            modulo: 'Roles',
            controlador: 'Rol',
            funcion: 'getPermisosRol',
            id_rol: idRol
        },
        success: function (response) {

            if (!response || response.success === false) {
                $('#contenedorPermisos').html(
                    "<p class='text-danger'>No se pudieron cargar los permisos</p>"
                );
                return;
            }

            if (response.permisos.length === 0) {
                $('#contenedorPermisos').html(
                    "<p class='text-muted'>Este rol no tiene permisos asignados</p>"
                );
                return;
            }

            let html = '';

            response.permisos.forEach(function (grupo) {
                html += '<div class="mb-3">';
                html += '<h6 class="fw-bold">' + grupo.modulo + '</h6>';
                html += '<div class="d-flex flex-wrap gap-2">';

                grupo.acciones.forEach(function (accion) {
                    html += '<span class="px-2 py-1 border rounded bg-light">' + accion + '</span>';
                });

                html += '</div>';
                html += '</div>';

            });

            $('#contenedorPermisos').html(html);
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });

}

$('#buscar').on('keyup', function() { cargarTabla(); });
$('#comuna').on('change', function() { cargarTabla(); });

function cargarTabla() {
    var buscar = $('#filtro').val();
    var comuna = $('#comuna').val();

    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        data: {
            modulo: 'Zoocriaderos',
            controlador: 'Zoocriadero',
            funcion: 'filtro',
            buscar: buscar,
            comuna: comuna
        },
        success: function (html) {
            $('tbody').html(html);
        }
    });
}