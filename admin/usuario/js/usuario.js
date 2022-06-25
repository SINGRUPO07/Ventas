$(document).ready(function () {
  var datosUsuario;
  cargardatos();

  function cargardatos() {
    $.get( "usuarioCtl.php", function( data ) {
      datosUsuario = data;
      var items = [];
      $.each( data, function( key, val ) {
        items.push( "<div class='row fila'>"+
          "<div class='col columna'>"+val.usuario+"</div>"+
          "<div class='col columna'>"+val.ctipo+"</div>"+
          "<div class='col columna'>"+val.cestado+"</div>"+
          "<div class='col columna'>"+
          "<button class='btn btn-outline-secondary btn-sm ver-detalle' data-pos='"+
            key+"' data-id='"+val.id+"'>Ver detalle</button>"+
          "<button class='btn btn-outline-secondary btn-sm cambiar-estado' data-pos='"+
            key+"' data-id='"+val.id+"'>"+(val.estado==0 ? "Activar" : "Desactivar")+"</button>"+
          "</div>"+
          "</div>"
        );
      });
      $("#datos-usuarios .detalle").html(items.join( "" ));
      $(".ver-detalle").on("click", function(evt) { verdetalle(evt);  });
      $(".cambiar-estado").on("click", function(evt) { cambiarestado(evt);  });
    });
  }
  function verdetalle(evt) {
    //console.log("ver detalle evt", evt);
    var oObj = $(evt.currentTarget);
    var oData = datosUsuario[oObj.attr("data-pos")];
    var items = [];
    items.push("<form class='form'>");
    items.push("<div class='form-floating mb-3'>");
    items.push("<input type='text' readonly class='form-control' name='usuario' value='"+oData.usuario+"' /><label for='usuario'>Nombre de usuario:</label>");
    items.push("</div>");
    items.push("<div class='form-floating mb-3'>");
    items.push("<input type='text' readonly class='form-control' name='tipo' value='"+oData.ctipo+"' /><label for='tipo'>Tipo de usuario:</label>");
    items.push("</div>");
    items.push("<div class='form-floating mb-3'>");
    items.push("<input type='text' readonly class='form-control' name='estado' value='"+oData.cestado+"' /><label for='estado'>Estado de usuario:</label>");
    items.push("</div>");
    items.push("</form>");
    var botones = [];
    botones.push("<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>");
    //botones.push("<button type='button' class='btn btn-primary'>Guardar</button>");

    $("#modal-detalle .modal-body").html(items.join(""));
    $("#modal-detalle .modal-footer").html(botones.join(""));
    $("#modal-detalle").modal("show");
  }

  function cambiarestado(evt) {
    var oObj = $(evt.currentTarget);
    var sElem = oObj.attr("data-id");
    $.post("usuarioCtl.php", { id: sElem, accion: "CE" }, function(evt) { cargardatossuccess(evt); })
  }

  function cargardatossuccess(evt) {
    cargardatos();
  }
});
