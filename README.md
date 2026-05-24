AR Barberia

Guía detallada de arquitectura y manual de usuario disponible en:
https://mintlify.wiki/OswalSnow/AR-Barber/introduction

Requisitos del sistema

    PHP 8.x

    Composer

    Node.js & NPM

    Servidor de base de datos (MariaDB/MySQL)

Instalación

    Clonar el repositorio:
    Bash

    git clone https://github.com/OswalSnow/AR-Barber.git
    cd AR-Barber

    Instalar dependencias:
    Bash

    composer install
    npm install && npm run build

    Configuración de variables de entorno:
    Bash

    cp .env.example .env
    php artisan key:generate

    Configurar las credenciales de base de datos en el archivo .env.

    Ejecutar migraciones y datos semilla:
    Bash

    php artisan migrate --seed

    Iniciar servidor:
    Bash

    php artisan serve

Stack Tecnológico

    Backend: Laravel

    Frontend: Blade, Bootstrap 5

    Base de datos: MariaDB

    Testing: PHPUnit

Pruebas automatizadas

Para ejecutar las pruebas del sistema:
Bash

php artisan test --filter AppointmentTest
