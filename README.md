# Laravel Survey with Chart.js

[![GitHub Stars](https://img.shields.io/github/stars/IlyasKohistani/laravel-survey.svg)](https://github.com/IlyasKohistani/laravel-survey/stargazers) [![GitHub Issues](https://img.shields.io/github/issues/IlyasKohistani/laravel-survey.svg)](https://github.com/IlyasKohistani/laravel-survey/issues) [![Current Version](https://img.shields.io/badge/version-1.0.0-green.svg)](https://github.com/IlyasKohistani/laravel-survey)

A simple survey project. You can take a survey and see what kind of shoppers you are. there are three kind of shoppers in this system Fast shoppers, Value shoppers, and Inspiration shoppers. You are 100% allowed to use this webpage for both personal and commercial use, but NOT to claim it as your own.

---

## Buy me a coffee

Whether you use this project, have learned something from it, or just like it, please consider supporting it by buying me a coffee, so I can dedicate more time on open-source projects like this :)

<a href="https://www.buymeacoffee.com/ilyaskohistani" target="_blank"><img src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: auto !important;width: auto !important;" ></a>

---

## Features

-   Authentication
-   Survey
-   Find out what type of shoppers you are.
-   Graphic displaying of results using Chart.js

---

## Setup

-   After you clone this repo to your desktop, go to its root directory using `cd laravel-survey` command on your cmd or terminal.
-   run `composer install` on your cmd or terminal to install dependencies.
-   Copy .env.example file to .env on the root folder using `copy .env.example .env` if using command prompt Windows or `cp .env.example .env` if using terminal, Ubuntu.
-   Open your .env file and change the database name (DB_DATABASE) to whatever you have, Username (DB_USERNAME), and Password (DB_PASSWORD) fields correspond to your configuration.
-   Run `php artisan key:generate` to generate new key.
-   Run `php artisan migrate:fresh` to publishe all our schema to the database and seed your database.
-   Run `php artisan serve` to start project.
-   Open http://localhost:8000/ in your browser.

---

## Usage

After you are done with the setup open http://localhost:8000/ in your browser. You can play with it and change anything you want. Enjoy!

---

## License

> You can check out the full license [here](https://github.com/IlyasKohistani/laravel-survey/blob/master/LICENSE)
> This project is licensed under the terms of the **MIT** license.
