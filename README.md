<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Api mini E-commerce

## Descripción

Una pequeña api para un E-commerce en el que se pueden hacer operaciones crud sobre categorias, marcas y productos. Los usuarios pueden registrarse e iniciar sesion para realizar diferentes acciones. También se pueden realizar ordenes para un usuario con diferentes productos, los cuales se iran descontando del stock de cada producto para mantener actualizado el almacen. Las ordenes tienen diferentes estados (pendientes, entregado, cancelado, etc.) que permiten darle seguimiento a cada orden para ver en qué punto se encuentran. Algunas acciones solo están permitidas para usuarios de tipo administrador.

## Pasos para ejecutar el proyecto
1. Descarga o clona el proyecto
2. Ejecuta el comando **`composer install`**
4. Copia en archivo **.env.example** y renombralo a **.env**
5. Edita las variables de entorno para la conexión a la base de datos.
6. Ejecuta el comando **`php artisan key:generate`**
7. Ejecuta el comando **`php artisan migrate`**
8. Ejecuta el comando **`php artisan serve`**
10. La url  para las peticiones es [http://127.0.0.1:8000/api](http://127.0.0.1:8000/api)
