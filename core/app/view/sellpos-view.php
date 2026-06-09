<div class="row">
  <div class="col-md-12">
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <h2 class="text-primary"><i class="bi bi-cart-plus"></i> Nueva Orden de Producción</h2>
        <p class="text-muted"><b>Buscar material o servicio por nombre o por código:</b></p>
        <form id="searchp" onsubmit="return false;">
          <input type="hidden" name="view" value="sellpos">
          <div class="row">
            <div class="col-md-10">
              <input type="text" id="product_code" name="product" class="form-control form-control-lg" autocomplete="off" placeholder="Escriba el nombre o código del producto/servicio...">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary btn-lg w-100"><i class="bi bi-search"></i> Buscar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card mb-4 border-warning shadow-sm">
      <div class="card-header bg-warning text-dark fw-bold">
        <i class="bi bi-exclamation-triangle-fill"></i> DATOS DE PRODUCCIÓN (Obligatorios para el Taller)
      </div>
      <div class="card-body bg-light">
        <div class="row">
          <div class="col-md-4">
            <label class="fw-bold form-label">Prioridad de Fabricación</label>
            <select id="prod_prioridad" name="prioridad" class="form-select">
              <option value="Baja">Baja (Normal)</option>
              <option value="Media" selected>Media (Estándar)</option>
              <option value="Alta">Alta (Urgente)</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="fw-bold form-label">Fecha de Entrega Acordada</label>
            <input type="date" id="prod_fecha_entrega" name="fecha_entrega" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="fw-bold form-label">Enlace del Diseño Aprobado</label>
            <input type="url" id="prod_diseno_url" name="diseno_url" class="form-control" placeholder="Ej: Link de Drive, Canva, etc.">
          </div>
        </div>
        <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle"></i> Nota: Llene estos datos antes de procesar la venta. Se enviarán directamente a las pantallas de los operarios.</small>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-header bg-dark text-white"><i class="bi bi-box-seam"></i> CATÁLOGO DE PRODUCTOS</div>
      <div class="card-body">
        <div id="show_search_results" class="row">
          <div class="col-md-12 text-center text-muted py-5">
            <p><i class="bi bi-cart4" style="font-size: 4rem; color: #e0e0e0;"></i></p>
            <h4>Realice una búsqueda para comenzar a armar la orden.</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div id="cart_summary">
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white fw-bold"><i class="bi bi-receipt"></i> RESUMEN DE ORDEN</div>
        <div class="card-body text-center text-muted py-5">
          <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
          <p class="mt-3">Sincronizando carrito...</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  // Cargar carrito al iniciar
  updateCart();

  $("#searchp").on("submit",function(e){
    e.preventDefault();
    searchProducts();
    return false;
  });

  var typingTimer;
  var doneTypingInterval = 500;

  $("#product_code").on("keyup", function () {
    clearTimeout(typingTimer);
    if ($(this).val().length > 2) {
      typingTimer = setTimeout(searchProducts, doneTypingInterval);
    }
  });

  function searchProducts(){
    var q = $("#product_code").val();
    if(q==""){ return; }
    $.get("./?action=searchproductpos", {product: q}, function(data){
      $("#show_search_results").html(data);
    });
  }

  function addToCart(product_id){
    var q = $("#q-"+product_id).val();
    $.post("./?action=addtocartpos", {product_id: product_id, q: q}, function(data){
      if(data.trim() == "error_insufficient_stock"){
        Swal.fire('Atención', 'No hay suficiente stock en inventario para agregar esa cantidad.', 'warning');
      } else {
        updateCart();
      }
    });
  }
  window.addToCart = addToCart;

  function updateCart(){
    $.get("./?action=cartpos", function(data){
      $("#cart_summary").html(data);
    });
  }
  window.updateCart = updateCart;

  function deleteFromCart(product_id){
    $.get("./?action=delfromcartpos", {product_id: product_id}, function(data){
      updateCart();
    });
  }
  window.deleteFromCart = deleteFromCart;
});
</script>