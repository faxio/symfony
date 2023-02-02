#### debuger

- si queremos ver el estado de nuestra app en todo momento podemos intalar el debuger.

```
composer require debug
```

* dump($tracks); -> sirve para ver el estado de la variable en un icono de apuntado en el debuger

* dd($tracks); -> sirve para que se vea dentro de la página la variable

*{{ dump(tracks) }} -> en el archivo .twig nos permitira colocarlo donde nosotros queramos

* {{ dump() }} -> Podemos ver todas las variables a las que tiene acceso nuestra app