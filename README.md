# Easy Procedures

Easy Procedures is a modernized bank procedure management system built with CakePHP. It features a sleek, responsive frontend and a robust RESTful API for seamless integration.

## Key Features
- **Modern UI:** Responsive, utility-first design using Tailwind CSS.
- **Hybrid Architecture:** Supports traditional MVC views and a modern REST API.
- **Secure API:** Stateless authentication using JSON Web Tokens (JWT).
- **Interactive Documentation:** Fully documented API using Swagger/OpenAPI.
- **Role-Based Access:** Tailored experiences for Administrators, Agents, and Clients.

## Technology Stack
- **Backend:** [CakePHP 4.4](https://cakephp.org)
- **Frontend CSS:** [Tailwind CSS 3.4](https://tailwindcss.com)
- **Frontend JS:** [Alpine.js 3.15](https://alpinejs.dev)
- **API Auth:** [Firebase JWT](https://github.com/firebase/php-jwt)
- **API Docs:** [Swagger Bake](https://github.com/cnizzardini/cakephp-swagger-bake)

## Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd easy-procedures
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Frontend dependencies:**
   ```bash
   npm install
   ```

4. **Build Frontend Assets:**
   ```bash
   npm run build
   ```

5. **Configuration:**
   - Copy `config/app_local.example.php` to `config/app_local.php` and configure your database.
   - Set a secure `JWT_SECRET` in your environment or `config/app.php`.

## Running the Project

### 1. Built-in Development Server
The quickest way to start the project is using CakePHP's built-in server:
```bash
bin/cake server -p 8765
```
Once started, you can access the application at `http://localhost:8765`.

### 2. Traditional Web Server (XAMPP/WAMP/Apache)
If you are using XAMPP or a similar Apache environment:
- Ensure your virtual host points to the `webroot` directory.
- Access the project via your configured local domain (e.g., `http://localhost/easy-procedures`).

## Usage

### Web Interface
Access the main dashboard through your browser at the root URL (e.g., `http://localhost:8765`).

### REST API
The API is versioned and located under `/api/v1`.
- **Authentication:** Authenticate via `POST /api/v1/users/login.json` to receive a JWT.
- **Documentation:** Visit `/swagger` on your local server to view the interactive API documentation.

## Development
- To watch for frontend changes during development:
  ```bash
  npm run watch
  ```
- To update API documentation after code changes:
  ```bash
  php bin/cake.php swagger bake
  ```

For a detailed history of architectural changes, please refer to the [DevChangelog.md](./DevChangelog.md).
