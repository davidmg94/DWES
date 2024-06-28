// Espera a que el documento esté listo
$(document).ready(function () {
   // Función para manejar la búsqueda
   // Esta función recibe el criterio como parámetro y realiza una petición AJAX al servidor
   // para obtener los resultados de la búsqueda.
   function buscar(criterio) {
      // Realiza una petición AJAX utilizando jQuery
      $.ajax({
         // URL del archivo que procesa la búsqueda
         url: "search2.php",
         // Método de la petición (POST)
         type: "post",
         // Datos que se envían al servidor (el criterio)
         data: { criterio: criterio },
         // Función que se ejecuta si la petición tiene éxito
         success: function (data) {
            // Actualiza el contenido del elemento con id 'tabla' con la respuesta del servidor
            $("#tabla").html(data);
         },
         // Función que se ejecuta si la petición falla
         error: function (jqXHR, textStatus, errorThrown) {
            // Muestra un mensaje de error en la consola
            console.error("Error al realizar la búsqueda:", errorThrown);
         },
      });
   }

   // Evento que detecta la escritura en el elemento con id 'criterio'
   // Cuando se escribe algo en el elemento, se llama a la función buscar()
   // con el valor actual del elemento como parámetro.
   $("#buscar").on("keyup", function () {
      // Obtiene el valor actual del elemento
      let criterio = $(this).val();

      // Realiza la búsqueda
      buscar(criterio);
   });
   // $("#buscar").on("input", function () {
   //    // Obtiene el valor actual del elemento
   //    let criterio = $(this).val();

   //    // Realiza la búsqueda
   //    buscar(criterio);
   // });
});
