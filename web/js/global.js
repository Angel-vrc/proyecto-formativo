$(document).ready(function () {

    $(document).on("keyup", "#filtro", function () {
        // Si existe el elemento #comuna, estamos en la página de zoocriaderos
        // y debemos usar cargarTabla() para considerar todos los filtros
        if ($('#comuna').length > 0) {
            cargarTabla();
        } else {
            // Para otras páginas, mantener el comportamiento original
            let data = $(this).val();
            let url = $(this).data("url");

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    buscar: data
                },
                success: function (data) {
                    $("tbody").html(data);
                }
            });
        }
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
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });

}

$('#buscar').on('keyup', function () { cargarTabla(); });
$('#comuna').on('change', function () { cargarTabla(); });

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

$('#comuna2').on('change', function () { cargarTabla2(); });

function cargarTabla2() {
    var comuna2 = $('#comuna2').val();

    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        data: {
            modulo: 'Reportes',
            controlador: 'ReporteZoocriadero',
            funcion: 'filtro',
            comuna: comuna2
        },
        success: function (html) {
            $('tbody').html(html);
        }
    });
}

$('#nombreRol').on('blur', function () { validarRol(); });

function validarRol(){
    var nombre = $('#nombreRol').val().trim();

    console.log(nombre);

    if (nombre === '') return;

    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        dataType: 'json',
        data: {
            modulo: 'Roles',
            controlador: 'Rol',
            funcion: 'validarRol',
            nombre: nombre
        },
        success: function (response) {
            if (!response.disponible) {
                alert('Este rol ya existe');
                $('#nombreRol').val('').focus();
            }
        }
    });
}

$('#nombreZoocriadero').on('blur', function () { validarZoocriadero(); });

function validarZoocriadero(){
    var nombre = $('#nombreZoocriadero').val().trim();

    console.log(nombre);

    if (nombre === '') return;

    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        dataType: 'json',
        data: {
            modulo: 'Zoocriaderos',
            controlador: 'Zoocriadero',
            funcion: 'validarZoocriadero',
            nombre: nombre
        },
        success: function (response) {
            if (!response.disponible) {
                alert('Este zoocriadero ya existe');
                $('#nombreZoocriadero').val('').focus();
            }
        }
    });
}

