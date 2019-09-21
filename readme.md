<!-- <p align="center"><img src="https://photos.google.com/photo/AF1QipPWIhEDtkUKnKtx-QlHDZiu6Mj3ZpVPFiNNSQ2E" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p> -->




<h1> AjoCard P2P / Fund Transfer</h1>
<h3>Project Description </h3>
<p>1. This API Receive the transaction parameters from Authenticated User.</p>
<p>2. Validate the transaction parameters, </p>
<p>3. Move the funds, while keeping an audit log of the transactions.</p>

<h3> This Project was Built with Laravel PHP Framework for Backend API</h3>
<p>
<h3>POSTMAN API DOCUMENTATION</h3>
<p> https://documenter.getpostman.com/view/3188911/SVmwwJP5</p>

<h1>Installation</h1>

<ul>
<li>Clone the repo <code>git clone https://github.com/obynonwane/AjoCardP2P.git</code></li>
<li><code>cd </code> to project folder.</li>
<li>Run <code>composer install</code></li>
<li>Save the <code>.env.example</code> as <code>.env</code> and set your database information</li>
<li>Run <code> php artisan key:generate</code> to generate the app key</li>
<li>Run <code>npm install</code></li>
<li>Run <code>php artisan migrate</code></li>
<li>Done !!! Enjoy Your Fund Transfer</li>
</ul>

<p>Your <code>client_id</code> and <code>client_secret</code> can be gotten from  <code>oauth_clients</code> table in the database (mysql database was used)</p>