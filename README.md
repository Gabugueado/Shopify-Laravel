# 🛍️ Shopify OMS - Laravel Technical Test

Este proyecto fue desarrollado como parte de una **prueba técnica** para evaluar integración con Shopify, autenticación de usuarios y generación de reportes en Laravel.

Incluye:

- Registro y Autenticación de usuarios.
- Conexión con tiendas Shopify mediante **OAuth**.
- Visualización de **productos** y **órdenes recientes (últimos 30 días)**.
- Exportación de datos a **Excel** o **CSV**.

---

## ⚙️ Requisitos previos

Antes de iniciar, asegúrate de tener instalados los siguientes componentes:

- PHP >= 8.2  
- Composer  
- SQLite o MySQL  
- Node.js + npm  
- Laravel CLI (`composer global require laravel/installer`)

---

## 🚀 Instalación del proyecto

1. **Clona el repositorio**

   ```bash
   git clone https://github.com/tu-usuario/shopify-oms.git
   cd shopify-oms
   ```

2. **Instala las dependencias**

   ```bash
   composer install
   npm install
   ```

3. **Crea el archivo de entorno**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configura la base de datos**
   Edita el archivo `.env` y agrega tus credenciales, por ejemplo:

   ```.env
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database.sqlite
   ```

   Si usas MySQL:

   ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=shopify_oms
    DB_USERNAME=root
    DB_PASSWORD=
   ```

5. **Ejecuta las migraciones**

   ```bash
   php artisan migrate
   ```

6. **Inicia el servidor**

   ```bash
   php artisan serve
   ```

---

## 🔐 Autenticación de usuario

El sistema requiere login para acceder al dashboard.  
Puedes registrarte desde `/register` o iniciar sesión desde `/login`.

---

## 🛒 Conexión con Shopify

### 1. Configurar una App Privada / Custom App en Shopify

1. Entra a tu panel de Shopify → *Settings* → *Apps and sales channels* → *Develop apps*.  
2. Crea una nueva app con los permisos:
   ```read_products, read_orders```
3. En la sección **App setup**, configura:
   - **App URL:** `http://localhost:8000`
   - **Redirect URL:** `http://localhost:8000/shopify/callback`

4. Guarda los valores:

    ```env
    SHOPIFY_API_KEY= 
    SHOPIFY_API_SECRET=
    ```

    y añádelos a tu `.env`.

### 2. Iniciar conexión desde la app

1. Inicia sesión en tu app Laravel.
2. Haz clic en **“Conectar con Shopify”**.
3. Autoriza la aplicación en tu tienda.
4. Automáticamente se guardará el `access_token` y el dominio de tu tienda.

---

## 📦 Visualización y Exportación

- Al conectar una tienda, el dashboard mostrará:
  - **Productos:** Nombre, SKU, precio, imagen.
  - **Órdenes:** Cliente, fecha, estado y productos comprados.
- Los datos pueden exportarse a:
  - Excel (`.xlsx`)
  - CSV (`.csv`)

### Exportar manualmente

```bash
GET /shopify/products/export/excel
GET /shopify/products/export/csv
```
