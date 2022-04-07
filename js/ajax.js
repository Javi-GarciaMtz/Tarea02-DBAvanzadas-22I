
$(document).ready(function() {
    $('#ingresarUbicacion').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'php/mainPHP.php',
            data: $(this).serialize(),
            success: function(response)
            {
                var jsonData = JSON.parse(response);

                if(jsonData.success == 1) {
                    window.alert("Se añadio la nueva ubicación correctamente");
                } else {
                    window.alert("Error al añadir la ubicación!");
                }

            }
        });
    });
});

$(document).ready(function() {
    $('#modUbicacion').submit(function(e) {
        e.preventDefault();
        // console.log($(this).serialize());
        $.ajax({
            type: "POST",
            url: 'php/mainPHP.php',
            data: $(this).serialize(),
            success: function(response)
            {
                var jsonData = JSON.parse(response);
                // console.log(jsonData);

                if(jsonData.success == 1) {
                    window.alert("Se modifico correctamente");
                } else {
                    window.alert("Error al modificar!");
                }

            }
        });
    });
});

$(document).ready(function() {
    $('#consultaUbicaciones').submit(function(e) {
        e.preventDefault();
        // console.log($(this).serialize());
        $.ajax({
            type: "POST",
            url: 'php/mainPHP.php',
            data: $(this).serialize(),
            success: function(response)
            {
                var jsonData = JSON.parse(response);
                // console.log(jsonData);

                if(jsonData.success == 1) {
                    window.alert("El estado consultado tiene "+jsonData['estadoConsulta']+" ubicaciones");
                } else {
                    window.alert("Error al consultar!");
                }

            }
        });
    });
});

