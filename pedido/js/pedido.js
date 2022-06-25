$(document).ready(function () {
  var datosCarrito;
  cargardatos();
  // $("#cambiar-localrecojo").on("click", function(evt) { cambiarlocalrecojo(evt); });
  // $("#enviar-pedido").on("click", function(evt) { generarpedido(evt); });

  function cambiarlocalrecojo(evt) {
    var oElem = $(evt.currentTarget);
    var sElem = oElem.attr("data-id");
    $.get( "../controladores/localCtl.php", function( data ) {
      cargalocalsuccess(data, sElem);
      $("#set-local-recojo").on("click", function(evt) { setlocalrecojo(evt); });
    });
  }

  function cargalocalsuccess(data, sActivo) {
    var items = [];
    var botones = [];

    items.push("<form class='form form-horizontal'>");
    items.push("<div class='row'>");
    items.push("<div class='col-md-4'>Local:</div>");
    items.push("</div>");
    items.push("<div class='col-md-8'>");
    items.push("</div>");
    items.push("<select id='select-local' name='select-local' class='form-control'>");
    $.each( data, function( key, val ) {
      items.push("<option value='"+val.id+"' "+(val.id==sActivo ? "selected" : "")+">"+val.nombre+"</option>");
    });
    items.push("</select>");
    items.push("</form>");

    botones.push("<button type='button' id='set-local-recojo' class='btn btn-success'>Aceptar</button>");
    botones.push("<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>");

    $("#modal-detalle .modal-title").html("Seleccionar Local de recojo");
    $("#modal-detalle .modal-body").html(items.join(""));
    $("#modal-detalle .modal-footer").html(botones.join(""));
    $("#modal-detalle").modal("show");
  }

  function setlocalrecojo(evt) {
    oElem = $("#select-local");
    xElem = oElem.find(" option:selected");
    $.post("../controladores/localCtl.php", { id: xElem.val(), accion: "SL" }, function(data) {
      setlocalrecojosuccess( data, { id: xElem.val(), nombre: xElem.html() } );
      $("#modal-detalle").modal("hide");
    });

  }

  function setlocalrecojosuccess(data, obj) {
    if(data.resultado.codigo==0) {
      var oElem = $("#cambiar-localrecojo");
      oElem.attr("data-id", obj.id);
      oElem.html(obj.nombre);
    }
  }

  function cargardatos() {
    $.get( "./pedidoCtl.php", function( data ) { cargadatossuccess(data); });
  }

  function cargadatossuccess(data) {
    datosPedido = data.datos;
    var items = [];
    $.each( datosPedido, function( key, val ) {
      items.push("<div class='row pedido'>");
      items.push("  <div class='col-lg-5 col-md-6'>"+val.cusuario+"</div>");
      items.push("  <div class='col-lg-2 col-md-6'>"+val.clocal+"</div>");
      items.push("  <div class='col-lg-2 col-md-3'>"+val.ctipopago+"</div>");
      items.push("  <div class='col-lg-1 col-md-3'>"+val.monto_total+"</div>");
      items.push("  <div class='col-lg-1 col-md-3'>"+val.cestado+"</div>");
      items.push("  <div class='col-lg-1 col-md-3'>");
      items.push("    <button class='btn btn-outline-danger btn-sm anular-pedido "+(val.estado!=1 ? "disabled" : "")+"' data-id='"+val.id+"'>Anular Pedido</button>");
      items.push("  </div>");
      items.push("</div>");
    });

    $("main.pedidos .contenedor-central").html(items.join(""));
    $("main.pedidos .contenedor-central .anular-pedido").on("click", function(evt) { anularpedido(evt); });
  }

  function anularpedido(evt) {
    var oObj = $(evt.currentTarget);
    var sElem = oObj.attr("data-id");
    if(confirm("¿Seguro de anular el pedido?")==1) {
      $.post("./pedidoCtl.php", { id: sElem, accion: "AP" }, function(data) { anularpedidosuccess(data); });
    }
  }

  function anularpedidosuccess(data) {
    var r = data.resultado;
    if(r.codigo==0) {
      cargardatos();
      alert(r.mensaje);
    } else {
      alert(r.mensaje+"\n\n"+r.mensaje_detalle);
    }
  }

});
