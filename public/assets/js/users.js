document.addEventListener("DOMContentLoaded", () => {
  const Swal = window.Swal;

  // Botón añadir usuario
  const addUserBtn = document.getElementById("add-user-btn");
  if (addUserBtn) {
    addUserBtn.addEventListener("click", () => {
      Swal.fire({
        title: "Añadir Nuevo Usuario",
        html: `
          <form id="add-user-form" class="user-form">
            <div class="form-group">
              <label for="new-username">Nombre de usuario</label>
              <input type="text" id="new-username" class="swal2-input" placeholder="Nombre de usuario" required>
            </div>
            <div class="form-group">
              <label for="new-email">Correo electrónico</label>
              <input type="email" id="new-email" class="swal2-input" placeholder="correo@ejemplo.com" required>
            </div>
            <div class="form-group">
              <label for="new-password">Contraseña</label>
              <input type="password" id="new-password" class="swal2-input" placeholder="Contraseña" required>
            </div>
          </form>
        `,
        showCancelButton: true,
        confirmButtonText: "Crear Usuario",
        cancelButtonText: "Cancelar",
        customClass: {
          popup: "user-modal",
        },
        preConfirm: () => {
          const username = document.getElementById("new-username").value;
          const email = document.getElementById("new-email").value;
          const password = document.getElementById("new-password").value;

          if (!username || !email || !password) {
            Swal.showValidationMessage("Todos los campos son obligatorios");
            return false;
          }

          if (password.length < 6) {
            Swal.showValidationMessage("La contraseña debe tener al menos 6 caracteres");
            return false;
          }

          // Aquí iría la lógica para crear el usuario mediante AJAX
          return {username, email, password};
        },
      }).then((result) => {
        if (result.isConfirmed) {
          // Simulación de éxito
          Swal.fire({
            icon: "success",
            title: "Usuario creado",
            text: `El usuario ${result.value.username} ha sido creado exitosamente`,
            timer: 2000,
            showConfirmButton: false,
          }).then(() => {
            // Recargar la página para mostrar el nuevo usuario
            window.location.reload();
          });
        }
      });
    });
  }
});

// Función para editar usuario
function editUser(userId) {
  const Swal = window.Swal;

  Swal.fire({
    title: "Editar Usuario",
    html: `
      <form id="edit-user-form" class="user-form">
        <div class="form-group">
          <label for="edit-username">Nombre de usuario</label>
          <input type="text" id="edit-username" class="swal2-input" placeholder="Cargando..." disabled>
        </div>
        <div class="form-group">
          <label for="edit-email">Correo electrónico</label>
          <input type="email" id="edit-email" class="swal2-input" placeholder="Cargando..." disabled>
        </div>
        <div class="form-group">
          <label for="edit-password">Nueva contraseña (opcional)</label>
          <input type="password" id="edit-password" class="swal2-input" placeholder="Dejar vacío para mantener actual">
        </div>
      </form>
    `,
    showCancelButton: true,
    confirmButtonText: "Guardar Cambios",
    cancelButtonText: "Cancelar",
    customClass: {
      popup: "user-modal",
    },
    didOpen: () => {
      // Aquí cargarías los datos del usuario desde el servidor
      // Por ahora simulamos la carga
      setTimeout(() => {
        document.getElementById("edit-username").disabled = false;
        document.getElementById("edit-email").disabled = false;
        document.getElementById("edit-username").value = "usuario_ejemplo";
        document.getElementById("edit-email").value = "usuario@ejemplo.com";
      }, 500);
    },
    preConfirm: () => {
      const username = document.getElementById("edit-username").value;
      const email = document.getElementById("edit-email").value;
      const password = document.getElementById("edit-password").value;

      if (!username || !email) {
        Swal.showValidationMessage("El nombre de usuario y email son obligatorios");
        return false;
      }

      if (password && password.length < 6) {
        Swal.showValidationMessage("La contraseña debe tener al menos 6 caracteres");
        return false;
      }

      return {userId, username, email, password};
    },
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        icon: "success",
        title: "Usuario actualizado",
        text: "Los cambios han sido guardados exitosamente",
        timer: 2000,
        showConfirmButton: false,
      }).then(() => {
        window.location.reload();
      });
    }
  });
}

// Función para eliminar usuario
function deleteUser(userId, username) {
  const Swal = window.Swal;

  Swal.fire({
    title: "¿Estás seguro?",
    text: `Esta acción eliminará permanentemente al usuario "${username}" y todos sus datos asociados.`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#6c757d",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Mostrar loading
      Swal.fire({
        title: "Eliminando usuario...",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });

      // Realizar petición AJAX para eliminar
      fetch("/users/delete", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `user_id=${userId}`,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            Swal.fire({
              icon: "success",
              title: "Usuario eliminado",
              text: `El usuario "${username}" ha sido eliminado exitosamente`,
              timer: 2000,
              showConfirmButton: false,
            }).then(() => {
              window.location.reload();
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: data.error || "No se pudo eliminar el usuario",
            });
          }
        })
        .catch((error) => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Error de conexión. Inténtalo de nuevo.",
          });
        });
    }
  });
}
