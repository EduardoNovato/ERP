# ERP Lite 🚀

Un **ERP Lite** desarrollado en PHP, que incluye login, registro y dashboard con gráficas. El proyecto corre con Docker para una instalación sencilla y rápida.

---

## 🛠️ Requisitos

Antes de comenzar, asegúrate de tener instalado:

- [Git](https://git-scm.com/)
- [Docker + Docker Compose](https://www.docker.com/get-started)

> Si usas Linux y aún no tienes Docker y Compose, puedes instalarlos con:

```bash
sudo apt update
sudo apt install docker.io docker-compose-plugin -y
sudo usermod -aG docker $USER
newgrp docker
```

---

## 🚀 Instalación rápida

Sigue estos pasos:

1. **Clona el repositorio**

```bash
git clone https://github.com/EduardoNovato/ERP.git
cd ERP
```

2. **Construye y ejecuta los contenedores**

```bash
docker compose up -d
```

3. **Abre la aplicación en tu navegador**

```
http://localhost:8000
```

---

## 📂 Estructura del proyecto

```
ERP/
├── app/               ← Lógica de backend (Auth.php, Database.php, config.php)
├── public/            ← Archivos visibles (index.php, register.php, dashboard.php, css/, js/)
├── docker-compose.yml ← Configuración de servicios (PHP y MySQL)
├── Dockerfile         ← Imagen personalizada de PHP + Apache
```

---

## 🧪 Funcionalidades actuales

- Registro de usuarios
- Inicio de sesión seguro con validación
- Dashboard básico con gráficas (Highcharts)
- Notificaciones con SweetAlert2
- Autenticación con sesiones PHP

---

## 🗂️ Servicios de Docker

- `app`: Servidor Apache + PHP 8.2 (puerto `8000`)
- `db`: MySQL 8.0 (puerto `3306`, persistencia de datos)

---

## 🔐 Acceso

Una vez que accedas a `http://localhost:8000`, podrás:

- Registrarte desde `register.php`
- Iniciar sesión desde `index.php`
- Acceder al dashboard en `dashboard.php`

---

## 🧱 Próximos pasos

Este proyecto es solo el inicio de un ERP Lite. Se planea incluir módulos como:

- Gestión de inventario
- Control de usuarios y roles
- Facturación
- Reportes
- Más dashboards y analíticas

---

## 🤝 Contribuciones

¡Eres bienvenido a colaborar! Si tienes ideas o deseas mejorar el sistema, haz un fork y envía tu PR.

---

## 📝 Licencia

Este proyecto está bajo la licencia MIT. Puedes usarlo libremente.
