# Desafío bsale Backend Ecommerce

En el desafío 'bsale', consiste en realizar un pequeño e-commerce, en este repositorio podrá encontrar el proyecto BACKEND quien es el encargado de conectarse a la base de datos y brindar servicios API REST para que puedan ser consumidos por el FRONTEND que lo puede encontrar en el siguiente repositorio. 
```sh
> https://github.com/marco121942/bsaleFrontend
```

### Requisitos

Tecnologías necesarias para el correcto funcionamiento de la aplicación:

* PHP 7.3.0 >=

### Instalación

Clonar el respositorio ejecute.

```sh
> git clone https://github.com/marco121942/bsaleBackend.git
```

Instalar dependencias composer.

```sh
> composer install
```
### Variables de entorno

Modifique los valores por defecto de `.env`, para la correcta ejecución del proyecto, tiene que modificar las credenciales de la base de datos.

```sh
> cp .env.example .env
```

```json
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```


### Despliegue

Ejecute el siguiente comando para el correcto funcionamiento del proyecto.

```sh
> php artisan serve
```

### Servicios realizados - {{APP_URL_DEV}} -> ejm "http://localhost:8080"
- Obtener todos los productos que existen en la BD.

Mediante una petición GET, obtendrás como respuesta un array de objetos de todos los productos.

```sh
> {{APP_URL_DEV}}/api/v1/get/product
```
Respuesta esperada:

![image](https://user-images.githubusercontent.com/42647311/201555348-951ced9c-2698-4e87-9e5a-f02585211140.png)

- Obtener todos los productos clasificados mediante su categoría.

Mediante una petición GET, obtendrás como respuesta un array de objetos de todas las categorías con sus respectivos productos.

```sh
> {{APP_URL_DEV}}/api/v1/get/productCategory
```
Respuesta esperada:

![image](https://user-images.githubusercontent.com/42647311/201555626-5ee8a926-0f61-4e26-926d-2caa3660dc20.png)

- Buscador de productos mediante una palabra clave.

Mediante una petición POST y el envío del parámetro 'keyword', obtendrás todos los productos que coincidan con la palabra clave enviada.

```sh
> {{APP_URL_DEV}}/api/v1/search/product
```
Parámetro esperado:

```json
{
    "keyword":"pis"
}
```
Respuesta esperada:

![image](https://user-images.githubusercontent.com/42647311/201556328-c71a5aa4-e245-4df4-ba47-00a7df6e128c.png)

- Filtrado de productos.

Mediante una petición POST y el envío de los parámetros 'typeFilter' y 'dataFilter', obtendrás todos los productos que cumplan el filtrado.

```sh
> {{APP_URL_DEV}}/api/v1/filter/product
```

typeFilter:

Puede recibir uno de los siguientes datos 'category','imagen','discount',son los campos mediante el cual se va realziar el filtrado.


dataFilter:

             . si es por 'category' , se debe enviar el ID de la categoría.

             . si es por 'imagen' , se debe enviar 0 o 1.
             
             . si es por 'discount' , se debe enviar 0 o 1.
             
Parámetro esperado:

```json
{
    "typeFilter":"category",
    "dataFilter":2
}
```
Respuesta esperada:

![image](https://user-images.githubusercontent.com/42647311/201557169-35826715-11a4-47f4-b789-72bc6e537569.png)
