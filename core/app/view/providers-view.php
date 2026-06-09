<div class="row">
  <div class="col-md-12">
    <h2 class="text-success fw-bold"><i class="bi bi-truck"></i> Directorio de Proveedores</h2>
    <p class="text-muted">Centralice a sus proveedores (incluyendo contactos de San Salvador y locales) para dejar de comprar a ciegas y agilizar las órdenes de materia prima.</p>
    
    <div class="mb-3 d-flex justify-content-between">
      <a href="index.php?view=newprovider" class="btn btn-success fw-bold shadow-sm"><i class="bi bi-person-plus"></i> Registrar Nuevo Proveedor</a>
      <a href="report/providers-pdf.php" target="_blank" class="btn btn-danger text-white fw-bold shadow-sm"><i class="bi bi-file-earmark-pdf"></i> Descargar PDF</a>
    </div>

    <div class="card shadow-sm border-success">
      <div class="card-header bg-dark text-white fw-bold">PROVEEDORES REGISTRADOS</div>
      <div class="card-body p-0">
        <?php
        $users = PersonData::getProviders();
        if(count($users)>0){
        ?>
        <div class="table-responsive">
          <table class="table table-bordered table-hover mb-0 align-middle text-center">
            <thead class="bg-light">
              <tr>
                <th class="text-start">Nombre de Empresa o Contacto</th>
                <th class="text-start">Dirección / Ubicación</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($users as $user){ ?>
              <tr>
                <td class="text-start fw-bold text-dark"><?php echo $user->name." ".$user->lastname; ?></td>
                <td class="text-start"><i class="bi bi-geo-alt text-danger"></i> <?php echo $user->address1; ?></td>
                <td><?php echo $user->email1; ?></td>
                <td class="fw-bold"><?php echo $user->phone1; ?></td>
                <td>
                  <a href="index.php?view=editprovider&id=<?php echo $user->id;?>" class="btn btn-warning btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                  <a href="index.php?view=delprovider&id=<?php echo $user->id;?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <?php }else{ ?>
          <div class="p-5 text-center text-muted bg-light">
            <i class="bi bi-truck" style="font-size: 4rem; color:#ccc;"></i>
            <h4 class="mt-3">No hay proveedores registrados</h4>
            <p>Agregue a sus proveedores actuales de San Salvador o locales para llevar un mejor control de sus compras e inventarios.</p>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>