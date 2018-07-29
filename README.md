# voucher-pool
It is micro service component for managing set of offers, recipients &amp; their voucher codes.

Framework - Lumen (https://lumen.laravel.com/docs/5.6)
1) Setup local dev environment taking reference of above link (PHP >= 7.1.3)
2) Copy .env.example to .env file & use your configuration (Create database & provide required details)
3) Execute "php artisan migrate:fresh" in terminal to setup tables (Reach to you poject folder for executing this cmd)
4) Execute "php artisan db:seed" in terminal to populate dependant data (like offers, recipients)
5) Hit your API endpoints for accessing required details (For more details, refer to sent email)
