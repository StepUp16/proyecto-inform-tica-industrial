<div class="row mb-4">
  <div class="col-md-12">
    <h2 class="fw-bold text-primary"><i class="bi bi-people-fill"></i> Gestión de Usuarios</h2>
    <p class="text-muted">Administración de cuentas de acceso al sistema (Vendedores, Producción y Gerencia).</p>
    
    <div class="mb-4">
      <a href="index.php?view=newuser" class="btn btn-primary fw-bold shadow-sm"><i class='bi bi-person-plus'></i> Registrar Nuevo Usuario</a>
    </div>

    <div class="card shadow-sm border-primary">
      <div class="card-header bg-dark text-white fw-bold">DIRECTORIO DE ACCESOS</div>
      <div class="card-body p-0">
        <?php
        $users = UserData::getAll();
        if(count($users)>0){
        ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle text-center">
              <thead class="bg-light">
                <tr>
                  <th class="text-start">Nombre Completo</th>
                  <th>Usuario (Login)</th>
                  <th>Rol de Sistema</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach($users as $user){ ?>
                <tr>
                  <td class="text-start fw-bold"><?php echo $user->name." ".$user->lastname; ?></td>
                  <td class="text-muted"><?php echo $user->username; ?></td>
                  <td>
                    <?php if($user->is_admin): ?>
                      <span class="badge bg-danger"><i class="bi bi-shield-lock-fill"></i> Administrador</span>
                    <?php else: ?>
                      <span class="badge bg-info text-dark"><i class="bi bi-tools"></i> Operario / Ventas</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($user->is_active): ?>
                      <span class="badge bg-success">Activo</span>
                    <?php else: ?>
                      <span class="badge bg-secondary">Inactivo</span>
                    <?php endif; ?>
                  </td>
                  <td style="width:150px;">
                    <a href="index.php?view=edituser&id=<?php echo $user->id;?>" class="btn btn-sm btn-warning shadow-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                    <?php if($user->id != $_SESSION["user_id"]):?>
                      <a href="index.php?view=deluser&id=<?php echo $user->id;?>" class="btn btn-sm btn-danger shadow-sm" title="Eliminar" onclick="return confirm('¿Eliminar usuario?');"><i class="bi bi-trash"></i></a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        <?php } else { ?>
          <div class="p-4 text-center text-muted">No hay usuarios registrados.</div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>