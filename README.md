# Mi-primer-trabajo-UIBB
Sitio web para acceder a los currilums de alumnos egresados de escuelas tecnicas

### Sistema web:
* Implementado en PHP usando framework Laravel
* /project: archivos de la aplicación
* /www: carpeta publica
* Para instalar:
```
cd project
composer install
php artisan migrate
```

* Update assets (compilar scss, concatenar y minificar js, copiar achrivos de /maquetas a /www)
```
cd project
// Dev
gulp
// Producción (minificado)
gulp --production 
```

### Maquetas  (/maquetas)
* Carga Alumno: http://hernan224.github.io/Mi-primer-trabajo-UIBB/maquetas/carga-alumno.html
* Vista Alumno: http://hernan224.github.io/Mi-primer-trabajo-UIBB/maquetas/vista-alumno.html
* Listado Alumnos (para empresas): http://hernan224.github.io/Mi-primer-trabajo-UIBB/maquetas/listado-frontend.html
* Listado Alumnos (para escuelas): http://hernan224.github.io/Mi-primer-trabajo-UIBB/maquetas/listado-backend.html
