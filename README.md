Getting Started
Follow these steps to set up and run the project locally.

1. Prerequisites
PHP 8.2+
Composer
Node.js & NPM
A database server (MySQL/MariaDB recommended)
2. Installation
Clone the repository:

git clone https://github.com/git-wahab/saas-onboarding.git
cd saas-onboarding
Install dependencies:

composer install
npm install
Setup Environment File:

Copy the example environment file:
cp .env.example .env
Create a database for the landlord application (e.g., landlord_db).
Update your .env file with your database credentials. Set DB_CONNECTION to mysql or your preferred driver and update the DB_DATABASE, DB_USERNAME, and DB_PASSWORD variables. Do not change DB_CONNECTION from the default sqlite in .env, as the multitenancy configuration relies on specific connection names. Instead, you will configure the connections directly in config/database.php or use environment variables that match the config.
Generate Application Key:

php artisan key:generate
Run Landlord Migrations & Seed: This command will set up the necessary tables for the landlord application and seed it with admin users and roles.

php artisan migrate --database=landlord --path=database/migrations/landlord
php artisan db:seed --database=landlord
Configure Local Hostname Resolution: For the domain-based multi-tenancy to work, you need to point the app domains to your local server. Add the following lines to your system's hosts file (/etc/hosts on macOS/Linux, C:\Windows\System32\drivers\etc\hosts on Windows):

127.0.0.1 multitenant.test
127.0.0.1 landlord.multitenant.test
You will also need to add an entry for each tenant you create (e.g., 127.0.0.1 acme.multitenant.test). Using a tool like Laravel Valet (macOS) or setting up a wildcard DNS entry with a local DNS server can simplify this.

3. Running the Application
Start the development servers using the provided script. This will run the php artisan serve command, listen to the queue, and start the Vite development server.
npm run dev
Alternatively, run the commands separately:
php artisan serve
npm run dev
4. Accessing the Application
Main Site (for new users): http://multitenant.test:8000

Admin Panel: http://landlord.multitenant.test:8000/admin/dashboard

Super Admin Login: superadmin@admin.com / password123
Admin Login: admin@admin.com / password123
Tenant Workspace: After registering a new user and creating a tenant (e.g., acme), you can access it at: http://acme.multitenant.test:8000
