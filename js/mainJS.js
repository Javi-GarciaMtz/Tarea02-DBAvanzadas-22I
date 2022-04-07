
function escribeConsulta(data, consulta) {

    $('#TableTitle').empty();
    $('#TableTitle').append(consulta)

    $('#Table').empty();

    $('#Table').append(
    '<thead>' +
        '<tr>' +
        '<th scope="col">Nombre</th>' +
        '<th scope="col">Estado</th>' +
        '<th scope="col">Dirección</th>' +
        '<th scope="col">Calificación</th>' +
        '<th scope="col">Descripción</th>' +
        '</tr>' +
    '</thead>');

    $('#Table').append('<tbody>');
    for(i=0; i<data['NOMBRE'].length; i++) {
        $('#Table').append(
            '<tr>' +
            '<th scope="row">'+data['NOMBRE'][i]+'</th>' +
            '<td>'+data['ESTADO'][i]+'</td>' +
            '<td>'+data['UBICACIONEXACTA'][i]+'</td>' +
            '<td>'+data['CALIFICACION'][i]+'</td>' +
            '<td>'+data['DESCRIPCION'][i]+'</td>' +
            '</tr>');
    }
    $('#Table').append('</tbody>');

}

function consultaUbicaciones() {

    var data = $(this).serializeArray();
    data.push({name: "consultarUbicaciones", value: true});

    $.ajax({
        type: "POST",
        url: 'php/mainPHP.php',
        data: $.param(data),
        success: function(response)
        {
            var jsonData = JSON.parse(response);

            if(jsonData.success == 1) {
                window.alert("Datos Obtenidos Correctamente!");
                escribeConsulta(jsonData['data'], 'Lugares Agregados');
            } else {
                window.alert("Error al obtener los datos!");
            }

        }
    });

}