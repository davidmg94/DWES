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

   /*
   // Función para cargar las provincias al seleccionar un país
   $("#pais").change(function(){
      let paisID = $(this).val();
      $.ajax({
         url: 'getProvincias.php',
         type: 'post',
         data: {pais:paisID},
         dataType: 'json',
         success:function(response){
            let len = response.length;
            $("#provincia").empty();
            for( let i = 0; i<len; i++){
               let id = response[i]['id'];
               let name = response[i]['name'];
               $("#provincia").append("<option value='"+id+"'>"+name+"</option>");
            }
            $("#provincia").show(); // Mostrar el selector de provincias
         }
      });
   });

   // Función para cargar las localidades al seleccionar una provincia
   $("#provincia").change(function(){
      let provID = $(this).val();
      $.ajax({
         url: 'getLocalidades.php',
         type: 'post',
         data: {provincia:provID},
         dataType: 'json',
         success:function(response){
            let len = response.length;
            $("#localidad").empty();
            for( let i = 0; i<len; i++){
               let id = response[i]['id'];
               let name = response[i]['name'];
               $("#localidad").append("<option value='"+id+"'>"+name+"</option>");
            }
            $("#localidad").show(); // Mostrar el selector de localidades
         }
      });
   });
   */

   // Función para cargar las provincias al presionar el botón "Mostrar"
   $("#mostrar").click(function () {
      let paisID = $("#pais").val();
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
               $("#mostrarLocalidades").removeAttr("hidden"); // Mostrar el botón de "Mostrar Localidades"
               $("#mostrar").attr("hidden", "hidden"); // Ocultar el botón de "Mostrar"
            },
         });
      } else {
         // Alertar al usuario si no ha seleccionado un país
         alert("Por favor, seleccione un país antes de presionar Mostrar.");
      }
   });
});
