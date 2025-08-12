# SaaS Onboarding with Multi-Tenancy


This repository demonstrates a multi-tenant Software as a Service (SaaS) application built with Laravel 12. It features a complete user onboarding flow, from initial registration to tenant creation, and includes a landlord dashboard for managing tenants and users. The project leverages the `spatie/laravel-multitenancy` package for robust tenant separation.

## Key Features

-   **Multi-Tenancy with Spatie**: Utilizes domain-based tenant identification, where each tenant gets their own subdomain (`your-company.multitenant.test`) and a dedicated database.
-   **Landlord & Tenant Architecture**: A clear separation between the central landlord application (for management) and individual tenant applications (workspaces).
-   **Multi-Step User Onboarding**: A guided 3-step registration process for new users:
    1.  **Account Creation**: Basic user information (name, email, password).
    2.  **Billing Information**: Collect payment details.
    3.  **Workspace Setup**: Create a unique tenant with a custom domain.
-   **Role-Based Access Control (RBAC)**: Comes with pre-configured `super-admin` and `admin` roles with specific permissions for managing the platform.
-   **Admin Dashboard**: A dedicated dashboard for administrators to view platform statistics and manage tenants.
-   **Separate Authentication**: Distinct authentication guards and routes for the landlord admin panel and tenant workspaces.

## Architecture Overview

### Landlord

The "landlord" application is the central control panel, accessible via `multitenant.test` (for new registrations) and `landlord.multitenant.test` (for admin access). Its responsibilities include:
-   Managing global users (administrators and tenant owners).
-   Handling the multi-step registration and onboarding flow.
-   Creating and managing tenant records (domains, databases).
-   Overseeing billing information.

### Tenants

Each "tenant" represents an individual customer's workspace.
-   Each tenant is assigned a unique subdomain (e.g., `acme.multitenant.test`).
-   Each tenant has its own isolated database, ensuring data privacy and separation. The application automatically creates and migrates the tenant's database upon registration.
-   Users within a tenant workspace have their own authentication system, separate from the landlord application.

## Getting Started

Follow these steps to set up and run the project locally.

### 1. Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   A database server (MySQL/MariaDB recommended)

### 2. Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/git-wahab/saas-onboarding.git
    cd saas-onboarding
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment File:**
    -   Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    -   Create a database for the landlord application (e.g., `landlord_db`).
    -   Update your `.env` file with your database credentials. Set `DB_CONNECTION` to `mysql` or your preferred driver and update the `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` variables. **Do not change `DB_CONNECTION` from the default `sqlite` in `.env`, as the multitenancy configuration relies on specific connection names.** Instead, you will configure the connections directly in `config/database.php` or use environment variables that match the config.

4.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

5.  **Run Landlord Migrations & Seed:**
    This command will set up the necessary tables for the landlord application and seed it with admin users and roles.
    ```bash
    php artisan migrate --database=landlord --path=database/migrations/landlord
    php artisan db:seed --database=landlord
    ```

6.  **Configure Local Hostname Resolution:**
    For the domain-based multi-tenancy to work, you need to point the app domains to your local server. Add the following lines to your system's `hosts` file (`/etc/hosts` on macOS/Linux, `C:\Windows\System32\drivers\etc\hosts` on Windows):
    ```
    127.0.0.1 multitenant.test
    127.0.0.1 landlord.multitenant.test
    ```
    You will also need to add an entry for each tenant you create (e.g., `127.0.0.1 acme.multitenant.test`). Using a tool like [Laravel Valet](https://laravel.com/docs/valet) (macOS) or setting up a wildcard DNS entry with a local DNS server can simplify this.

### 3. Running the Application

-   Start the development servers using the provided script. This will run the `php artisan serve` command, listen to the queue, and start the Vite development server.
    ```bash
    npm run dev
    ```
-   Alternatively, run the commands separately:
    ```bash
    php artisan serve
    npm run dev
    ```

### 4. Accessing the Application

-   **Main Site (for new users):** [http://multitenant.test:8000](http://multitenant.test:8000)
-   **Admin Panel:** [http://landlord.multitenant.test:8000/admin/dashboard](http://landlord.multitenant.test:8000/admin/dashboard)

    -   **Super Admin Login:** `superadmin@admin.com` / `password123`
    -   **Admin Login:** `admin@admin.com` / `password123`

-   **Tenant Workspace:** After registering a new user and creating a tenant (e.g., `acme`), you can access it at: [http://acme.multitenant.test:8000](http://acme.multitenant.test:8000)

Video:
https://drive.google.com/file/d/1W4wK8bLdTc75bkVwBSe_szoqtTe7_CCo/view?usp=sharing
