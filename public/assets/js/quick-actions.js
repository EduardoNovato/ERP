document.addEventListener("DOMContentLoaded", () => {
  // Verificar si SweetAlert2 está disponible
  const Swal = window.Swal; // Declare the Swal variable
  if (typeof Swal === "undefined") {
    console.error("SweetAlert2 no está cargado. Asegúrate de incluir la biblioteca.");
    return;
  }

  // Botón Añadir Usuario
  const addUserButton = document.querySelector('.action-button[data-action="add-user"]');
  if (addUserButton) {
    addUserButton.addEventListener("click", () => {
      Swal.fire({
        title: "Añadir Nuevo Usuario",
        html: `
          <form id="quick-user-form" class="quick-form">
            <div class="form-group">
              <label for="username">Nombre de usuario</label>
              <input type="text" id="username" class="swal2-input" placeholder="Nombre de usuario">
            </div>
            <div class="form-group">
              <label for="email">Correo electrónico</label>
              <input type="email" id="email" class="swal2-input" placeholder="Correo electrónico">
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" id="password" class="swal2-input" placeholder="Contraseña">
            </div>
          </form>
        `,
        showCancelButton: true,
        confirmButtonText: "Crear Usuario",
        cancelButtonText: "Cancelar",
        customClass: {
          popup: "quick-action-modal",
        },
        preConfirm: () => {
          const username = document.getElementById("username").value;
          const email = document.getElementById("email").value;
          const password = document.getElementById("password").value;

          if (!username || !email || !password) {
            Swal.showValidationMessage("Todos los campos son obligatorios");
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
          });
        }
      });
    });
  }

  // Botón Nuevo Reporte
  const reportButton = document.querySelector('.action-button[data-action="new-report"]');
  if (reportButton) {
    reportButton.addEventListener("click", (e) => {
      e.stopPropagation();

      // Crear o mostrar el menú desplegable
      let reportMenu = document.querySelector(".report-dropdown");
      if (!reportMenu) {
        reportMenu = document.createElement("div");
        reportMenu.className = "report-dropdown";
        reportMenu.innerHTML = `
          <div class="report-item" data-type="users">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            Reporte de Usuarios
          </div>
          <div class="report-item" data-type="activity">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
            Actividad del Sistema
          </div>
          <div class="report-item" data-type="logins">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
              <polyline points="10 17 15 12 10 7"></polyline>
              <line x1="15" y1="12" x2="3" y2="12"></line>
            </svg>
            Inicios de Sesión
          </div>
        `;
        document.body.appendChild(reportMenu);

        // Posicionar el menú
        const rect = reportButton.getBoundingClientRect();
        reportMenu.style.top = `${rect.bottom}px`;
        reportMenu.style.left = `${rect.left}px`;

        // Manejar clics en los elementos del menú
        reportMenu.querySelectorAll(".report-item").forEach((item) => {
          item.addEventListener("click", function () {
            const reportType = this.getAttribute("data-type");
            generateReport(reportType);
            reportMenu.style.display = "none";
          });
        });
      }

      // Mostrar u ocultar el menú
      reportMenu.style.display = reportMenu.style.display === "block" ? "none" : "block";

      // Cerrar el menú al hacer clic fuera
      document.addEventListener("click", function closeMenu(e) {
        if (!reportMenu.contains(e.target) && e.target !== reportButton) {
          reportMenu.style.display = "none";
          document.removeEventListener("click", closeMenu);
        }
      });
    });
  }

  // Función para generar reportes
  function generateReport(type) {
    Swal.fire({
      icon: "info",
      title: "Generando reporte",
      text: `Preparando reporte de ${
        type === "users" ? "usuarios" : type === "activity" ? "actividad" : "inicios de sesión"
      }...`,
      timer: 2000,
      showConfirmButton: false,
    }).then(() => {
      // Aquí iría la lógica para generar el reporte
      Swal.fire({
        icon: "success",
        title: "Reporte generado",
        text: "El reporte ha sido generado exitosamente",
        showConfirmButton: true,
      });
    });
  }

  // Botón Enviar Mensaje
  const messageButton = document.querySelector('.action-button[data-action="send-message"]');
  if (messageButton) {
    messageButton.addEventListener("click", () => {
      Swal.fire({
        title: "Enviar Mensaje",
        html: `
          <form id="quick-message-form" class="quick-form">
            <div class="form-group">
              <label for="recipient">Destinatario</label>
              <select id="recipient" class="swal2-input">
                <option value="">Seleccionar usuario...</option>
                <option value="1">Carlos Rodríguez</option>
                <option value="2">Ana Martínez</option>
                <option value="3">Miguel Sánchez</option>
                <option value="4">Laura Gómez</option>
              </select>
            </div>
            <div class="form-group">
              <label for="subject">Asunto</label>
              <input type="text" id="subject" class="swal2-input" placeholder="Asunto del mensaje">
            </div>
            <div class="form-group">
              <label for="message">Mensaje</label>
              <textarea id="message" class="swal2-textarea" placeholder="Escribe tu mensaje aquí..."></textarea>
            </div>
          </form>
        `,
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
        customClass: {
          popup: "quick-action-modal",
        },
        preConfirm: () => {
          const recipient = document.getElementById("recipient").value;
          const subject = document.getElementById("subject").value;
          const message = document.getElementById("message").value;

          if (!recipient || !subject || !message) {
            Swal.showValidationMessage("Todos los campos son obligatorios");
            return false;
          }

          // Aquí iría la lógica para enviar el mensaje
          return {recipient, subject, message};
        },
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            icon: "success",
            title: "Mensaje enviado",
            text: "Tu mensaje ha sido enviado exitosamente",
            timer: 2000,
            showConfirmButton: false,
          });
        }
      });
    });
  }

  // Botón Más Acciones
  const moreActionsButton = document.querySelector('.action-button[data-action="more-actions"]');
  if (moreActionsButton) {
    moreActionsButton.addEventListener("click", () => {
      Swal.fire({
        title: "Acciones Adicionales",
        html: `
          <div class="more-actions-grid">
            <div class="more-action-item" data-action="settings">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
              </svg>
              <span>Configuración</span>
            </div>
            <div class="more-action-item" data-action="backup">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
              </svg>
              <span>Respaldo</span>
            </div>
            <div class="more-action-item" data-action="help">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
              </svg>
              <span>Ayuda</span>
            </div>
            <div class="more-action-item" data-action="notifications">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
              </svg>
              <span>Notificaciones</span>
            </div>
          </div>
        `,
        showConfirmButton: false,
        showCloseButton: true,
        customClass: {
          popup: "quick-action-modal",
        },
      });

      // Manejar clics en las acciones adicionales
      document.querySelectorAll(".more-action-item").forEach((item) => {
        item.addEventListener("click", function () {
          const action = this.getAttribute("data-action");
          Swal.close();

          // Simular acción seleccionada
          Swal.fire({
            icon: "info",
            title: "Acción seleccionada",
            text: `Has seleccionado: ${action}`,
            timer: 1500,
            showConfirmButton: false,
          });
        });
      });
    });
  }
});
