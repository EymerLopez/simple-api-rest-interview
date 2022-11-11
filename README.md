# Customer API Rest
## Requerimientos
* PHP >= 8.0
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Composer >= 2.3

## Instalación
1. Clonar el repositorio.
2. Ejecutar el comando ```composer install``` para instalar dependencias.
3. Ejecutar el comando ``` php artisan key:generate ``` para generar la clave de la aplicación.
4. Si no existe el arhivo '.env', entonces creélo y copie el contenido de '.env.example' al archivo creado y configure modifique según convenga.
5. Ejecute el comando ```php artisan migrate --seed``` para crear y rellenar las tablas de la base de datos.
6. Ejecute el comando ```php artisan users:create {nombre} {email} {password}``` para crear un usuario que haga uso de la API.
7. Testee.

## API

### URL
La URL principal se conforma por la dirección de dominio seguido de '/api' (localhost:8000/api ejemplo).

### Responses
Todas las respuestas de los endpoints serán en formato JSON y el cuerpo siempre contendrá lo siguiente:
```json
{
    'success': true|false,
    'message': 'message',
}
```
Si una petición es ***inválida*** (Código HTTP 422) se añadirá ``` 'errors': {'campo': [errores]}  ``` al cuerpo de la respuesta.

Si una petición es ***Válida*** y se debe retornar algo, se añadirá ``` 'data': [{data1}, {data2}, {data3}...] ``` al cuerpo de la respuesta.
### Token y peticiones
Para poder consumir la API necesita generar un token de acceso. Dicho token se genera enviando las credenciales correctas al endpoit ```login```.

Cuando haya generado generado el token, simplemente tendrá que añadir al Header de la petición una autorización tipo Api Key llamado ```X-Token``` con el valor del token generado.

### Endpoints
Todos los endpoints son capaces de devolver un código de estado 500.
Todos los campos en la columna Body Request con una "R" son requeridos mientras que los que tengan un "O" son opcionales.

| Endpoint              | Método | Descripión                                                        | Código HTTP             | Body Request                                                                   |
|-----------------------|:------:|-------------------------------------------------------------------|-------------------------|--------------------------------------------------------------------------------|
| login                 |  POST  | Genera un token de acceso para el usuario.                        | - 200<br>- 422          | email - R<br>password - R                                                      |
| logout                |  POST  | Destruye el token generado para el usuario.                       | - 200<br>- 422<br>- 404 |                                                                                |
| refresh               |  POST  | Refresca el token del usuario si está expirado.                   | - 200<br>- 422<br>- 404 |                                                                                |
| regions               |   GET  | Obtiene el listado de todas las regiones.                         | - 200                   |                                                                                |
| communes              |   GET  | Obtiene el listado de todas las comunas.                          | - 200                   |                                                                                |
| customers             |   GET  | Obtiene el listado de todos los clientes activos y no eliminados. | - 200                   |                                                                                |
| customers/create      |  POST  | Crea un nuevo cliente.                                            | - 200<br>- 422          | dni - R<br>id_com - R<br>email - R<br>name - R<br>last_name - R<br>address - O |
| customers/{dniOEmail} |   GET  | Obtiene a un cliente por DNI o E-mail.                            | - 200<br>- 404          |                                                                                |
| customers/{dniOEmail} | DELETE | Elimina a un cliente existente.                                   | - 200<br>- 404          |                                                                                |


