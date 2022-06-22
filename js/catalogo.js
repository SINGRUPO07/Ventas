$(document).ready(function () {
  var datosCategorias;
  var datosProductos;
  cargardatos();
  actualizarfiltro();

  function cargardatos() {
    $.get( "./controladores/categoriaCtl.php", function( data ) {
      //console.log("data", data);
      datosCategorias = data;
      var items = [];
      $.each( data, function( key, val ) {
        items.push("<li class='form-control-plaintext'><input type='checkbox' class='checkCategoria' data-id='"+val.id+"'>&nbsp;"+val.nombre+"</li>");
      });
      $(".contenedor-menu #lista-categorias").html(items.join(""));

      $(".checkCategoria").on("change", function(evt) { actualizarfiltro(evt); });
    });
  }

  function actualizarfiltro(evt) {
    var aObj = $(".checkCategoria");
    var items = [];
    $.each( aObj, function( key, val ) {
      if($(val).is(":checked")) {
        items.push($(val).attr("data-id"));
      }
    });
    $.get( "./controladores/productoCtl.php", { a: "L", ids: items.join("-") }, function( data ) { actualizarfiltrosuccess(data); });
  }

  function actualizarfiltrosuccess(data) {
    datosProductos = data;
    var items = [];
    $.each( data, function( key, val ) {
      items.push("<div class='card producto' style=\"background-image: url('./upload/p_"+val.id+".jpg');\">");
      items.push("  <div class='card-body'>");
      items.push("    <h5 class='card-title'>"+val.nombre+"</h5>");
      items.push("    <p class='card-text'>"+val.descripcion+"</p>");
      items.push("    <p class='card-text'>Precio: "+val.precio+"</p>");
      items.push("    <p class='card-text'>Stock: "+val.stock+"</p>");
      items.push("    <a href='#' class='btn btn-secondary btn-sm ver-detalle' data-id='"+val.id+"' data-pos='"+key+"'>Ver detalles</a>");
      items.push("    <a href='#' class='btn btn-success btn-sm agregar-carrito' data-id='"+val.id+"' data-pos='"+key+"'>Agregar al carrito</a>");
      items.push("  </div>");
      items.push("</div>");
    });
    $("main.catalogo .contenedor-central").html(items.join(""));
    $("main.catalogo .contenedor-central .producto .ver-detalle").on("click", function(evt) { verdetalle(evt); });
  }

  function verdetalle(evt) {
    var oObj = $(evt.currentTarget);
    var oData = datosProductos[oObj.attr("data-pos")];
    console.log("oObj", oObj);
    var items = [];
    var botones = [];
    items.push("<form class='form form-horizontal'>");
    items.push("<div class='row'>");
    items.push("<div class='col-md-4'><h5 class=''>"+oData.nombre+"</h5></div>");
    items.push("<div class='col-md-8'>"+oData.nombre+"</div>");
    items.push("</div>");
    items.push("<div class='row'>");
    items.push("<div class='col-md-4'>Descripcion:</div>");
    items.push("<div class='col-md-8'>"+oData.descripcion+"</div>");
    items.push("</div>");
    items.push("<div class='row'>");
    items.push("<div class='col-md-4'>Especificaciones:</div>");
    items.push("<div class='col-md-8'>"+oData.descripcionlarga+"</div>");
    items.push("</div>");
    items.push("<div class='row'>");
    items.push("<div class='col-md-4'>Precio:</div>");
    items.push("<div class='col-md-8'>"+oData.precio+"</div>");
    items.push("</div>");
    items.push("<div class='row'>");
    items.push("<div class='col-md-4'>Stock:</div>");
    items.push("<div class='col-md-8'>"+oData.stock+"</div>");
    items.push("</div>");
    items.push("</form>");

    botones.push("<button type='button' class='btn btn-success'>Agregar al carrito</button>");
    botones.push("<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>");

    $("#modal-detalle .modal-title").html("Detalle de Producto");
    $("#modal-detalle .modal-body").html(items.join(""));
    $("#modal-detalle .modal-footer").html(botones.join(""));
    $("#modal-detalle").modal("show");
  }
});
