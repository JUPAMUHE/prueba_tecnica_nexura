<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    .error{
        font-size: 14px !important;
        color: red !important;
    }
    .edit{
        cursor: pointer;
    }
    .delete{
        cursor: pointer;
    }
</style>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">EMPLEADOS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Lista de Empleados</h2>
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearEmpleadoModal"> <i class="fa-solid fa-user-plus"></i> Crear</button>
        </div>
        
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th><i class="fa-solid fa-user"></i> Nombre</th>
                    <th><i class="fa-solid fa-at"></i> Email</th>
                    <th class="text-center"><i class="fa-solid fa-venus-mars"></i> Sexo</th>
                    <th><i class="fa-solid fa-briefcase"></i> Área</th>
                    <th class="text-center"><i class="fa-regular fa-envelope"></i> Boletin</th>
                    <th class="text-center">Modificar</th>
                    <th class="text-center">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($empleados)) : ?>
                    <tr>
                        <td colspan="8" class="text-center">No hay empleados registrados.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($empleados as $empleado) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($empleado['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($empleado['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($empleado['sexo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($empleado['area_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center"> <?php echo htmlspecialchars($empleado['boletin'] == 1 ? 'SI' : 'NO', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center"><i class="fa-solid fa-pen-to-square edit" data-id="<?php echo htmlspecialchars($empleado['id'], ENT_QUOTES, 'UTF-8'); ?>"></i></td>
                            <td class="text-center"><i class="fa-solid fa-trash delete" data-id="<?php echo htmlspecialchars($empleado['id'], ENT_QUOTES, 'UTF-8'); ?>"></i></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="crearEmpleadoModal" tabindex="-1" aria-labelledby="crearEmpleadoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearEmpleadoModalLabel">Crear Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     
                    <div class="alert alert-danger errors" role="alert" style="display:none;">
                        
                    </div>
                     
                    <form id="empleadoForm">
                        <div class="form-inline">
                            <label for="nombre">Nombre completo *</label>
                            <input type="text" class="form-control " id="nombre" name="nombre" required>
                        </div>
                        <div class="form-inline mt-3">
                            <label for="email">Correo electrónico *</label>
                            <input type="email" class="form-control " id="email" name="email" required>
                        </div>
                        <div class="form-inline mt-3">
                            <label>Sexo *</label><br>
                            <div class="mx-4">
                                <div>
                                    <input type="radio" id="masculino" name="sexo" value="M" required> <label for="masculino">Masculino</label>
                                </div>
                                <div>
                                    <input type="radio" id="femenino" name="sexo" value="F" required> <label for="femenino">Femenino</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-inline mt-3">
                            <label for="area">Área *</label>
                            <select class="form-control " id="area" name="area" required>
                                <option value="">-Seleccionar-</option>
                                <?php foreach ($areas as $area): ?>
                                    <option value="<?php echo htmlspecialchars($area['id']); ?>">
                                        <?php echo htmlspecialchars($area['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-inline mt-3">
                            <label for="descripcion">Descripción *</label>
                            <textarea class="form-control " id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="form-inline mt-3">
                            <input type="checkbox" id="boletin" name="boletin">
                            <label for="boletin" class="">Deseo recibir boletín informativo</label>
                        </div>
                        <div class="form-group mt-3">
                            <label>Roles *</label><br>
                            <div class="mx-4">
                                <?php foreach ($roles as $role): ?>
                                    <input type="checkbox" name="roles[]" value="<?php echo htmlspecialchars($role['id']); ?>">
                                    <?php echo htmlspecialchars($role['nombre']); ?><br>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="form-group mt-3" hidden>
                            <input type="text" name="empleado_edit" id="empleado_edit" value="0">
                        </div>

                        <button type="" class="btn btn-primary mt-3 btn-guardar">Guardar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery Validate -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var BASE_URL = "<?php echo BASE_URL; ?>";
        $(document).ready(function() {

            $(document).on('click', '.delete', function() {
                var empleadoId = $(this).data('id');
                var url_index = BASE_URL + "/public/index.php?controller=EmpleadoController&action=index";

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: BASE_URL + "/public/index.php?controller=EmpleadoController&action=delete&id=" + empleadoId,
                            type: "POST",
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        '¡Eliminado!',
                                        'El empleado ha sido eliminado.',
                                        'success'
                                    ).then(() => {
                                        window.location.href = url_index;
                                    });
                                } else {
                                    Swal.fire(
                                        '¡Error!',
                                        'No se pudo eliminar el empleado.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log("Error en la solicitud AJAX:", status, error);
                                Swal.fire(
                                    '¡Error!',
                                    'Ocurrió un error al eliminar el empleado.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });


            $(document).on('click', '.edit', function() {
                var empleadoId = $(this).data('id');
                var url_edit = BASE_URL + "/public/index.php?controller=EmpleadoController&action=edit&id=" + empleadoId;

                $.ajax({
                    url: url_edit,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
              
                            $('#empleado_edit').val(response.data.id);
 
                            $('#nombre').val(response.data.nombre);
                            $('#email').val(response.data.email);
                            $('input[name="sexo"][value="' + response.data.sexo + '"]').prop('checked', true);
                            $('#area').val(response.data.area_id);
                            $('#descripcion').val(response.data.descripcion);
                            $('#boletin').prop('checked', response.data.boletin == 1);
           
                            $('input[name="roles[]"]').prop('checked', false);
                            response.data.roles.forEach(function(role) {
                                $('input[name="roles[]"][value="' + role + '"]').prop('checked', true);
                            });
                            $('#crearEmpleadoModalLabel').text('Editar Empleado');

                            $('#crearEmpleadoModal').modal('show');
                        }else {
                            console.log("Error al obtener los datos del empleado");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error en la solicitud AJAX:", status, error);
                    }
                });
            });

            
            $.validator.addMethod("checkboxGroup", function(value, element, options) {
                return $(options).filter(':checked').length > 0;
            }, "Por favor seleccione al menos un rol.");

            $("#empleadoForm").validate({
                rules: {
                    nombre: {
                        required: true,
                        minlength: 5
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    sexo: {
                        required: true
                    },
                    area: {
                        required: true
                    },
                    'roles[]': {
                        checkboxGroup: 'input[name="roles[]"]'
                    },
                    descripcion: {
                        required: true
                    }
                },
                messages: {
                    nombre: {
                        required: "Por favor ingrese su nombre",
                        minlength: "El nombre debe tener al menos 5 caracteres"
                    },
                    email: {
                        required: "Por favor ingrese su correo electrónico",
                        email: "Por favor ingrese un correo electrónico válido"
                    },
                    sexo: {
                        required: "Por favor seleccione su sexo",
                    },
                    area: {
                        required: "Por favor seleccione un área"
                    },
                    'roles[]': {
                        checkboxGroup: "Por favor seleccione al menos un rol"
                    },
                    descripcion: {
                        required: "Por favor ingrese una descripción"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") === 'roles[]') {
                        error.insertBefore(element.closest('.mx-4'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    var formData = $(form).serialize(); 
                    var url_store = BASE_URL + "/public/index.php?controller=EmpleadoController&action=store";
                    var url_index = BASE_URL + "/public/index.php?controller=EmpleadoController&action=index";

                    $.ajax({
                        url: url_store,
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                $('#crearEmpleadoModal').hide();
                                Swal.fire({
                                    title: 'OK',
                                    text: '¡Empleado creado con éxito!.',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = url_index;
                                    }
                                });
                            }else if(response.success_edit){
                                $('#crearEmpleadoModal').hide();
                                Swal.fire({
                                    title: 'OK',
                                    text: '¡Empleado editado con éxito!.',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = url_index;
                                    }
                                });
                            } else {
                                $(".errors").html(response.errors).show();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("Error en la solicitud AJAX:", status, error);
                        }
                    });
                }
            });

        });

    </script>
</body>
</html>
