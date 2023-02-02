### Proceso de aprendizaje con symfony

1. Para crear un proyecto utilizamos `symfony new mixed_vinyl`

-> para iniciar el servidor de desarrollo podemos escribir `symfony serve -d`


### Explicaciones de directorios

- **Public**: Si queremos que un archivo se accesible públicamente tiene que vivir dentro de public/ (css, imagenes , etc)

- **index.php**: se llama controlador frontal, independiente de la URL que vaya el usuario, éste es el script que siempre se ejecuta primero. 

- **composer.json**: Tiene todos los paquetes que necesitaremos a lo largo de nuestro desarrollo


- **src**: Tiene el 100% de nuestras clases y pasaremos dentro del 95% del tiempo ahí dentro

- **bin y var**: no deberiamos tocarlos en ningun momento.


## Web Framework

- todo framework web en cualquier lenguaje tiene el mismo trabajo: ayudarnos a crear páginas, ya sean páginas HTML, respuestas JSON de la API o arte ASCII. Y casi todos los marcos lo hacen de la misma manera: mediante un sistema de rutas y controladores. La ruta define la URL de la página y apunta a un controlador. El controlador es una función PHP que construye esa página.

Así que ruta + controlador = página. Son matemáticas, gente.

#### Creación de controler

1. Nos dirigimos al directorio src
2. Entramos a la carpeta controller
3. Creamos un archivo siguiendo el nombre de la clase + controller.php. (por ejemplo VinyController.php)

```
<?php

namespace App\Controller;

class VinyController
{
    
}
```

- Es importante hacer que coincida el directorio la palabra App podemos entender que referencia a src, por ejemplo si queremos colocar un archivo dentro del directorio controller, debería tener un namespace App\Controller

- Para que podamos hacer que la ruta se renderice en el navegador debemos escribir `composer require annotations`
- Ahora para crear rutas simplemente debemos importar

```
use Symfony\Component\Routing\Annotation\Route;
```

y para habilitar una ruta tenemos que:

```
/**
* @Route("/")
*/
```

* Si quisieramos devolver más que un solo mensaje debemos importar el elemento response

```
<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class VinyController
{
    /**
    * @Route("/")
    */
    public function homepage(): Response
    {

        return new Response('HOla');
    }
}
```
Hasta ahora lo que tenemos es
    * Una ruta en el navegador en http://localhost:8000/
    * Una función llamada homepage que retorna un objeto de tipo Response
    * Un retorno de una respuesta, en este caso un mensaje que dice hola.

Esto puede ser expandido hasta el punto de responder casi cualquier cosa.

#### Rutas comodines

- Cuando queremos obtener un parametro de la url -> podemos hacer esto

```
/**
* @Route("/browse/{slug}")
*/
public function browse(string $slug): Response
{
    return new Response('Soy una canción de tipo '.$slug);
}

```
lo que hace este código es obtener todo lo que colocamos después de http://localhost:8000/browse/....  .Por ejemplo si escribimos
http://localhost:8000/browse/Metal -> el mensaje que recibiriamos sería Soy una canción de tipo Metal

- Podemos hacer que el argumento no sea obligatorio 
`public function browse(string $slug = null): Response`

- Para poder utilizar templates, debemos escribir
`composer require templates` -> este bundle nos servirá de 3 paquetes importantes a la hora de crear templates.   

Para utilizar un template tenemos que hacer lo siguiente
(no olvidar imporatar -> use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;)
1. La clase debe extender AbstractController
    ```
    class VinyController extends AbstractController
    ```
2. Debemos enviar una respuesta, pero ahora utilizaremos el objeto render
    ```
    return $this->render('vinyl/homepage.html.twig',[
            'title' => 'Pb & James',
        ]);
    ```
    Con esa línea estamos diciendo que renderice el archivo llamado homepage.html.twig que se encuentra dentro de la carpeta vinyl dentro de templates, y además que contenga la variable title, que después podremos leer dentro del archivo .twig

    ```
    <h1>{{title}}</h1>

    <div>
        lorem ipsum
    </div>
    ```
    Las `{{}}` le dicen que queremos el valor que contiene esa variable.


2.1 Podemos complicarlo cuanto nosotros queramos, por ejemplo

`VinyController.php`
```
$tracks = [
    ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
    ['song' => 'Waterfalls', 'artist' => 'TLC'],
    ['song' => 'Creep', 'artist' => 'Radiohead'],
    ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
    ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
    ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
];

return $this->render('vinyl/homepage.html.twig',[
    'title' => 'Pb & James',
    'tracks' => $tracks,
]);
```

`homepage.html.twig`
```
<ul>
    {%for track in tracks%}
        <li>
            {{track.song}} - {{track.artist}}
        </li>
    {% endfor %}
</ul>
```

- Si queremos reutilizar una plantilla, podemos hacerlo de la siguiente manera

```
{% extends 'base.html.twig' %}


{% block body %}
< contenido >
{% endblock body %}

```
donde extends es el .twig que queremos usar de base.
Si por alguna razón quisieramos mantener el valor que tiene el padre, bastaría con {{ parent() }}

- Podemos devolver datos en formato JSON. utilizando JsonResponse

```
<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class SongController extends AbstractController
{
    /** 
     * @Route("/api/songs/{id}")
     */ 
    public function getSong($id): Response
    {
        // TODO query the database
        $song = [
            'id' => $id,
            'name' => 'Waterfalls',
            'url' => 'https://symfonycasts.s3.amazonaws.com/sample.mp3',
        ];
        return new JsonResponse($song);
    }
}
```
-> esta clase devuelve un objeto json