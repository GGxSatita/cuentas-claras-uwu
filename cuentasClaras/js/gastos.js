$(document).ready(function(){
    function cargarGastos(){
        let categoria = $("#categoria").val();
        let desde = $("#desde").val();
        let hasta = $("#hasta").val();
        let busqueda = $("#busqueda").val();

        $.ajax({
            url: "buscar_gastos.php",
            type: "GET",
            data: {
                categoria: categoria,
                desde: desde,
                hasta: hasta,
                busqueda: busqueda
            },
            success: function(data){
                $("#tabla_gastos").html(data);
            }
        });
    }

    // Cargar todos al inicio
    cargarGastos();

    // Botón Filtrar
    $("#filtrar").click(function(){
        cargarGastos();
    });

    // Búsqueda instantánea al escribir
    $("#busqueda").on("keyup", function(){
        cargarGastos();
    });
});
