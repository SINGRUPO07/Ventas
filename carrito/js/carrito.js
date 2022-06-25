$(document).ready(function () {
  var datosCarrito;
  cargardatos();
  cargarusuario();
  $("#cambiar-localrecojo").on("click", function(evt) { cambiarlocalrecojo(evt); });
  $("#enviar-pedido").on("click", function(evt) { generarpedido(evt); });

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
      console.log(data, obj);
      var oElem = $("#cambiar-localrecojo");
      oElem.attr("data-id", obj.id);
      oElem.html(obj.nombre);
    }
  }

  function cargardatos() {
    $.get( "./carritoCtl.php", function( data ) { cargadatossuccess(data); });
  }

  function cargadatossuccess(data) {
    datosCarrito = data.datos;
    var items = [];
    var xTotal = 0;
    var xImporte = 0;
    $.each( datosCarrito, function( key, val ) {
      xImporte = (val.precio*val.cantidad);
      xTotal += xImporte;
      items.push("<div class='row producto'>");
      items.push("  <div class='col-md-2 imagen' style=\"background-image: url('../upload/p_"+val.producto_id+".jpg');\"></div>");
      items.push("  <div class='col-md-9'>");
      items.push("    <div class='row'>");
      items.push("      <div class='col-lg-12 col-md-12'>"+val.cproducto+"</div>");
      items.push("      <div class='col-lg-12 col-md-12'>"+val.cdescripcion+"</div>");
      items.push("      <div class='col-lg-4 col-md-4'>Precio: "+val.precio+"</div>");
      items.push("      <div class='col-lg-4 col-md-4'>Cantidad: "+val.cantidad+"</div>");
      items.push("      <div class='col-lg-4 col-md-4'>Importe: "+xImporte+"</div>");
      items.push("    </div>");
      items.push("  </div>");
      items.push("  <div class='col-lg-1 col-md-1'>");
      items.push("    <button class='btn btn-outline-danger btn-sm quitar-carrito' data-id='"+val.id+"'>Quitar</button>");
      items.push("  </div>");
      items.push("</div>");
    });
    items.push("<div class='row total'>");
    items.push("  <div class='col-md-2 imagen'></div>");
    items.push("  <div class='col-md-9'>");
    items.push("    <div class='row'>");
    items.push("      <div class='col-lg-12 col-md-12'></div>");
    items.push("      <div class='col-lg-12 col-md-12'></div>");
    items.push("      <div class='col-lg-4 col-md-4'></div>");
    items.push("      <div class='col-lg-4 col-md-4'></div>");
    items.push("      <div class='col-lg-4 col-md-4'>Total: "+xTotal+"</div>");
    items.push("    </div>");
    items.push("  </div>");
    items.push("  <div class='col-lg-1 col-md-1'>");
    items.push("    <button class='btn btn-outline-danger btn-sm limpiar-carrito'>Limpiar Carrito</button>");
    items.push("  </div>");
    items.push("</div>");

    $("main.carrito .contenedor-central").html(items.join(""));
    $("main.carrito .contenedor-central .quitar-carrito").on("click", function(evt) { quitarcarrito(evt); });
    $("main.carrito .contenedor-central .limpiar-carrito").on("click", function(evt) { limpiarcarrito(evt); });
  }

  function quitarcarrito(evt) {
    var oObj = $(evt.currentTarget);
    var sElem = oObj.attr("data-id");
    $.post("./carritoCtl.php", { id: sElem, accion: "QC" }, function(data) { quitarcarritosuccess(data); });
  }

  function limpiarcarrito(evt) {
    var oObj = $(evt.currentTarget);
    var sElem = oObj.attr("data-id");
    $.post("./carritoCtl.php", { accion: "LC" }, function(data) { quitarcarritosuccess(data); })

  }

  function quitarcarritosuccess(data) {
    console.log("data", data);
    var r = data.resultado;
    if(r.codigo==0) {
      cargardatos();
      alert(r.mensaje);
    } else {
      alert(r.mensaje+"\n\n"+r.mensaje_detalle);
    }
  }

  function cargarusuario() {
    $.get( "../admin/usuario/usuarioCtl.php", { id: usuario.id }, function( data ) { cargarusuariosuccess(data); });
  }
  function cargarusuariosuccess(data) {
    var items = [];
    items.push("<div class='container-sm'>");
    items.push("  <form class='form form-horizontal'>");
    items.push("    <div class='row producto'>");
    items.push("      <div class='col-md-4'>Nombre: </div>");
    items.push("      <div class='col-md-8'>"+data.nombre+"</div>");
    items.push("    </div>");
    items.push("    <div class='row producto'>");
    items.push("      <div class='col-md-4'>Apellido: </div>");
    items.push("      <div class='col-md-8'>"+data.apellido+"</div>");
    items.push("    </div>");
    items.push("    <div class='row producto'>");
    items.push("      <div class='col-md-4'>Correo electrónico: </div>");
    items.push("      <div class='col-md-8'>"+data.correo+"</div>");
    items.push("    </div>");
    items.push("    <div class='row producto'>");
    items.push("      <div class='col-md-4'>Teléfono: </div>");
    items.push("      <div class='col-md-8'>"+data.telefono+"</div>");
    items.push("    </div>");
    items.push("    <div class='row producto'>");
    items.push("      <div class='col-md-4'>Local de recojo: </div>");
    items.push("      <div class='col-md-8'>"+data.clocal+"</div>");
    items.push("    </div>");
    items.push("    <div class='row producto'>");
    items.push("      <div class='col-md-4'>Tipo de Pago: </div>");
    items.push("      <div class='col-md-8'>");
    items.push("        <select id='tipopago' name='tipopago' class='tipo-pago form-control'>");
    items.push("        </select>");
    items.push("      </div>");
    items.push("    </div>");
    items.push("  </div>");
    items.push("</div>");

    $("main.carrito .contenedor-pedido").html(items.join(""));
    cargartipopago();
  }

  function cargartipopago() {
    $.get( "../controladores/tipopagoCtl.php", function( data ) { cargartipopagosuccess(data); });
  }

  function cargartipopagosuccess(data) {
    var items = [];
    items.push("<option value=''>Seleccione Tipo de Pago</option>");
    $.each( data, function( key, val ) {
      items.push("<option value='"+val.id+"'>"+val.nombre+"</option>");
    });
    $("main.carrito .contenedor-pedido #tipopago").html(items.join(""));
  }

  function generarpedido(evt){
    $.post("../controladores/pedidoCtl.php", { id: sElem, accion: "QC" }, function(data) { quitarcarritosuccess(data); });
  }

  function generarpedidosuccess(data){

  }
});
