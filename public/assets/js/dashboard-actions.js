document.addEventListener("DOMContentLoaded", () => {
  const Swal = window.Swal

  if (typeof Swal === "undefined") {
    console.error("SweetAlert2 no está cargado.")
    return
  }

  // Manejar todas las acciones rápidas
  document.querySelectorAll(".action-card").forEach((button) => {
    button.addEventListener("click", () => {
      const action = button.getAttribute("data-action")
      handleQuickAction(action)
    })
  })

  function handleQuickAction(action) {
    switch (action) {
      case "add-user":
        showAddUserModal()
        break
      case "new-report":
        showReportModal()
        break
      case "backup-data":
        showBackupModal()
        break
      case "system-settings":
        showSettingsModal()
        break
      default:
        console.log("Acción no reconocida:", action)
    }
  }

  function showAddUserModal() {
    Swal.fire({
      title: "Añadir Nuevo Usuario",
      html: `
        <div class="form-container">
          <div class="form-group">
            <label for="username">Nombre de usuario</label>
            <input type="text" id="username" class="swal2-input" placeholder="Ingrese el nombre de usuario">
          </div>
          <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" class="swal2-input" placeholder="correo@ejemplo.com">
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" class="swal2-input" placeholder="Contraseña segura">
          </div>
        </div>
      `,
      showCancelButton: true,
      confirmButtonText: "Crear Usuario",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#007bff",
      preConfirm: () => {
        const username = document.getElementById("username").value
        const email = document.getElementById("email").value
        const password = document.getElementById("password").value

        if (!username || !email || !password) {
          Swal.showValidationMessage("Todos los campos son obligatorios")
          return false
        }

        if (password.length < 6) {
          Swal.showValidationMessage("La contraseña debe tener al menos 6 caracteres")
          return false
        }

        return { username, email, password }
      },
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: "success",
          title: "Usuario creado exitosamente",
          text: `El usuario ${result.value.username} ha sido añadido al sistema`,
          timer: 3000,
          showConfirmButton: false,
        })
      }
    })
  }

  function showReportModal() {
    Swal.fire({
      title: "Generar Reporte",
      html: `
        <div class="report-options">
          <div class="report-option" data-type="users">
            <div class="option-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
            </div>
            <h4>Reporte de Usuarios</h4>
            <p>Lista completa de usuarios registrados</p>
          </div>
          <div class="report-option" data-type="activity">
            <div class="option-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
              </svg>
            </div>
            <h4>Actividad del Sistema</h4>
            <p>Registro de inicios de sesión y actividad</p>
          </div>
        </div>
      `,
      showCancelButton: true,
      showConfirmButton: false,
      cancelButtonText: "Cerrar",
      customClass: {
        popup: "report-modal",
      },
    })

    // Manejar clics en las opciones de reporte
    document.querySelectorAll(".report-option").forEach((option) => {
      option.addEventListener("click", function () {
        const reportType = this.getAttribute("data-type")
        Swal.close()
        generateReport(reportType)
      })
    })
  }

  function generateReport(type) {
    const reportNames = {
      users: "Usuarios",
      activity: "Actividad del Sistema",
    }

    Swal.fire({
      title: "Generando reporte...",
      text: `Preparando reporte de ${reportNames[type]}`,
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading()
      },
    })

    // Simular generación de reporte
    setTimeout(() => {
      Swal.fire({
        icon: "success",
        title: "Reporte generado",
        text: `El reporte de ${reportNames[type]} está listo para descargar`,
        confirmButtonText: "Descargar",
        showCancelButton: true,
        cancelButtonText: "Cerrar",
      })
    }, 2000)
  }

  function showBackupModal() {
    Swal.fire({
      title: "Respaldo de Datos",
      text: "¿Desea crear una copia de seguridad completa del sistema?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Crear Respaldo",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#28a745",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Creando respaldo...",
          text: "Este proceso puede tomar varios minutos",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading()
          },
        })

        // Simular proceso de respaldo
        setTimeout(() => {
          Swal.fire({
            icon: "success",
            title: "Respaldo completado",
            text: "La copia de seguridad se ha creado exitosamente",
            timer: 3000,
            showConfirmButton: false,
          })
        }, 3000)
      }
    })
  }

  function showSettingsModal() {
    Swal.fire({
      title: "Configuración del Sistema",
      html: `
        <div class="settings-container">
          <div class="setting-group">
            <h4>Configuración General</h4>
            <div class="setting-item">
              <label>
                <input type="checkbox" checked> Notificaciones por email
              </label>
            </div>
            <div class="setting-item">
              <label>
                <input type="checkbox"> Modo mantenimiento
              </label>
            </div>
          </div>
          <div class="setting-group">
            <h4>Seguridad</h4>
            <div class="setting-item">
              <label>
                <input type="checkbox" checked> Autenticación de dos factores
              </label>
            </div>
            <div class="setting-item">
              <label>
                <input type="checkbox" checked> Registro de actividad
              </label>
            </div>
          </div>
        </div>
      `,
      showCancelButton: true,
      confirmButtonText: "Guardar Cambios",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#007bff",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: "success",
          title: "Configuración guardada",
          text: "Los cambios han sido aplicados exitosamente",
          timer: 2000,
          showConfirmButton: false,
        })
      }
    })
  }
})

// Estilos adicionales para los modales
const style = document.createElement("style")
style.textContent = `
  .form-container .form-group {
    margin-bottom: 1rem;
    text-align: left;
  }
  
  .form-container label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #495057;
  }
  
  .report-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 1rem 0;
  }
  
  .report-option {
    padding: 1.5rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
  }
  
  .report-option:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
  }
  
  .option-icon {
    width: 50px;
    height: 50px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, #007bff, #66b3ff);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .option-icon svg {
    width: 24px;
    height: 24px;
    color: white;
  }
  
  .report-option h4 {
    margin: 0 0 0.5rem 0;
    color: #212529;
  }
  
  .report-option p {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
  }
  
  .settings-container {
    text-align: left;
  }
  
  .setting-group {
    margin-bottom: 1.5rem;
  }
  
  .setting-group h4 {
    margin: 0 0 1rem 0;
    color: #495057;
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 0.5rem;
  }
  
  .setting-item {
    margin-bottom: 0.75rem;
  }
  
  .setting-item label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
  }
`
document.head.appendChild(style)
