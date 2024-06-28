$(document).ready(function () {
   // Función para cargar los países al cargar la página
   $.ajax({
      url: "getPaises.php", // El archivo PHP que maneja la solicitud para obtener los países
      type: "post",
      dataType: "json",
      success: function (response) {
         let len = response.length;
         $("#pais").empty();
         // Iterar sobre el array de países y agregar cada uno como opción en el selector
         for (let i = 0; i < len; i++) {
            let id = response[i]["id"];
            let name = response[i]["name"];
            $("#pais").append("<option value='" + id + "'>" + name + "</option>");
         }
      },
   });

   // Función para cargar las provincias y localidades al presionar el botón "Mostrar"
   $("#mostrar").click(function () {
      let paisID = $("#pais").val();
      let provinciaID = $("#provincia").val();
      
      // Verificar si se ha seleccionado un país
      if (paisID != "") {
         // Cargar las provincias correspondientes al país seleccionado
         $.ajax({
            url: "getProvincias.php",
            type: "post",
            data: { pais: paisID },
            dataType: "json",
            success: function (response) {
               let len = response.length;
               $("#provincia").empty();
               // Iterar sobre el array de provincias y agregar cada una como opción en el selector
               for (let i = 0; i < len; i++) {
                  let id = response[i]["id"];
                  let name = response[i]["name"];
                  $("#provincia").append("<option value='" + id + "'>" + name + "</option>");
               }
               $("#provincia").show(); // Mostrar el selector de provincias
            },
         });

         // Si ya se ha seleccionado una provincia previamente, cargar las localidades correspondientes
         if (provinciaID != "") {
            $.ajax({
               url: "getLocalidades.php",
               type: "post",
               data: { provincia: provinciaID },
               dataType: "json",
               success: function (response) {
                  let len = response.length;
                  $("#localidad").empty();
                  // Iterar sobre el array de localidades y agregar cada una como opción en el selector
                  for (let i = 0; i < len; i++) {
                     let id = response[i]["id"];
                     let name = response[i]["name"];
                     $("#localidad").append("<option value='" + id + "'>" + name + "</option>");
                  }
                  $("#localidad").show(); // Mostrar el selector de localidades
               },
            });
         }
      } else {
         // Alertar al usuario si no ha seleccionado un país
         alert("Por favor, seleccione un país antes de presionar Mostrar.");
      }
   });
});
