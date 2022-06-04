<h5>This app was created as a test task for php-developer position in UnitedCode</h5>
<p>
    the task goal is to create app in laravel framework which fetch data of articles from https://laravel-news.com/blog for last 4 months.
    <br>
    All data is fetched once and stored in local DB
    All data can be edited by registered user with name editor, credentials for access: editor@gmail.com Password123
    <br>
    Project uses Laravel 9.15 version and php 8.1.0
    For auth purposes project uses Breeze and for css compiling Taliwindcss
</p>
Following commands should be run after git clone 
<ul>
<li>composer install</li>
<li>copy .env.example .env</li>
<li>php artisan key:generate</li>
<li>php artisan migrate</li>
</ul>
