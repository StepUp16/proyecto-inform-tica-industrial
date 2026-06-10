<div class="row mb-4">
  <div class="col-md-12">
    <h2 class="fw-bold text-primary"><i class="bi bi-truck"></i> Nuevo Proveedor</h2>
    <p class="text-muted">Registre un nuevo contacto o empresa para el abastecimiento de materia prima e insumos.</p>

    <div class="card shadow-sm border-primary mt-3">
      <div class="card-header bg-dark text-white fw-bold">
        DATOS DEL PROVEEDOR
      </div>
      <div class="card-body bg-light">
        <form method="post" action="index.php?view=addprovider">

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="name" class="form-label fw-bold">Nombre / Empresa*</label>
              <input type="text" name="name" class="form-control border-primary" id="name" placeholder="Ej. Papelera Central" required>
            </div>
            <div class="col-md-6">
              <label for="lastname" class="form-label fw-bold">Apellido / Persona de Contacto*</label>
              <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Ej. Juan Pérez" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-12">
              <label for="address1" class="form-label fw-bold">Dirección Completa*</label>
              <input type="text" name="address1" class="form-control" id="address1" placeholder="Ej. Local 4, Centro Comercial, Ciudad" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="email1" class="form-label fw-bold">Correo Electrónico</label>
              <input type="email" name="email1" class="form-control" id="email1" placeholder="ventas@proveedor.com">
            </div>
            <div class="col-md-6">
              <label for="phone1" class="form-label fw-bold">Teléfono / WhatsApp*</label>
              <input type="text" name="phone1" class="form-control" id="phone1" placeholder="Ej. 7000-0000" required>
            </div>
          </div>

          <div class="alert alert-info shadow-sm mt-4">
            <i class="bi bi-info-circle-fill"></i> Los campos marcados con asterisco (*) son de carácter obligatorio para mantener el orden en el directorio.
          </div>

          <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
            <i class="bi bi-save"></i> Guardar Registro del Proveedor
          </button>

        </form>
      </div>
    </div>    
  </div>
</div>