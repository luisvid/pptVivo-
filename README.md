# README #


### Sistema Operativo 

Versión de Sistema Operativo: Ubuntu Linux Lucid Server 10.04 64bits


### Zend Server 

Descargar desde http://www.zend.com/download/511?start=true
Version: ZendServer-5.6.0-RepositoryInstaller-linux.tar.gz
Colocarlo en /opt

tar xvf ZendServer-5.6.0-RepositoryInstaller-linux.tar.gz

cd ZendServer-RepositoryInstaller-linux

./install_zs.sh 5.3


### Configuración PHP (php.ini) 

mails
sendmail_path = \usr\bin\sendmail -t -i

Habilitar extensiones:
php_curl


### Configuración Apache 

Habilitar módulos:
mod_expires

Vhost (Se usan rutas y nombres de dominio de ejemplo):

* PPT Vivo! 

```
#!bash
<VirtualHost *:80>

        ServerAdmin webmaster@localhost
        DocumentRoot "/var/www/pptvivo/public"
        ServerName www-qa.pptvivo.com
        DirectoryIndex url.php

        <Directory "/var/www/pptvivo/public">
                AllowOverride None
                Order allow,deny
                Allow from all
                Options FollowSymLinks
                RewriteEngine on
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteRule [^\x00-,.-@[-^`{-\x7F] /url.php
        </Directory>

        #compress text, html, javascript, css, xml
        AddOutputFilterByType DEFLATE text/plain
        AddOutputFilterByType DEFLATE text/html
        AddOutputFilterByType DEFLATE text/xhtml
        AddOutputFilterByType DEFLATE text/xml
        AddOutputFilterByType DEFLATE text/css
        AddOutputFilterByType DEFLATE application/xml
        AddOutputFilterByType DEFLATE application/xhtml+xml
        AddOutputFilterByType DEFLATE application/rss+xml
        AddOutputFilterByType DEFLATE application/javascript
        AddOutputFilterByType DEFLATE application/x-javascript

        ExpiresActive on
        ExpiresDefault "access plus 15 days"
        ExpiresByType application/x-javascript "access plus 1 years"
        ExpiresByType application/javascript "access plus 1 years"
        ExpiresByType text/css "access plus 1 years"
        
		#Debe ser el mismo directorio absoluto que el indicado en el parámetro presentations.path.alias de config.ini 
		Alias /files/ /var/www/files/
		
		<Directory "/var/www/files/">
			AllowOverride None
			Options FollowSymLinks
			Order allow,deny
			Allow from all
		</Directory>
</VirtualHost>
```

* PPT Vivo! Viewer

```
#!bash
<VirtualHost *:80>
	
	ServerAdmin webmaster@localhost
	DocumentRoot "/var/www/pptvivo_viewer/public"
	ServerName viewer-dev.pptvivo.com
	DirectoryIndex url.php

	<Directory "/var/www/pptvivo_viewer/public">
		AllowOverride None
		Order allow,deny
		Allow from all
		Options FollowSymLinks
		RewriteEngine on
		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteRule [^\x00-,.-@[-^`{-\x7F] /url.php
	</Directory>

	#compress text, html, javascript, css, xml
	AddOutputFilterByType DEFLATE text/plain
	AddOutputFilterByType DEFLATE text/html
	AddOutputFilterByType DEFLATE text/xhtml
	AddOutputFilterByType DEFLATE text/xml
	AddOutputFilterByType DEFLATE text/css
	AddOutputFilterByType DEFLATE application/xml
	AddOutputFilterByType DEFLATE application/xhtml+xml
	AddOutputFilterByType DEFLATE application/rss+xml
	AddOutputFilterByType DEFLATE application/javascript
	AddOutputFilterByType DEFLATE application/x-javascript

	ExpiresActive on
	ExpiresDefault "access plus 15 days"
	ExpiresByType application/x-javascript "access plus 1 years"
	ExpiresByType application/javascript "access plus 1 years"
	ExpiresByType text/css "access plus 1 years"
	
	#Debe ser el mismo directorio absoluto que el indicado en el parámetro presentations.path.alias de config.ini 
	Alias /files/ /var/www/files/
	
	<Directory "/var/www/files/">
		AllowOverride None
		Options FollowSymLinks
		Order allow,deny
		Allow from all
	</Directory>
	
</VirtualHost>

```



### MySQL 

Antes de instalar el motor, hay que borrar cualquier version previa. Para ello podemos utilizar el comando

dpkg -l | grep mysql | awk -F' ' '{print $2}'
apt-get -y remove <nombre que aparezca en el resultado del comando anterior> 

Instalar mysql
apt-get install mysql-server mysql-client


### Sendmail 

apt-get install ssmtp mailutils sendmail

Editar el archivo /etc/ssmtp/sstmp.conf (Utilizar los datos que correspondan al cliente):


```
#!php

root=smtp@cvtargentina.com.ar
mailhub=smtp.gmail.com:587
hostname=smtp@cvtargentina.com.ar
UseTLS=YES
UseSTARTTLS=YES
AuthUser=smtp@cvtargentina.com.ar
AuthPass=Las-Pass-Que-Corresponda
FromLineOverride=YES
```


### NOTA: desde 2017 cambie a Postmark 


```
#!php

# Configure SMTP
# Learn more -> http://developer.postmarkapp.com/developer-send-smtp.html

Server: smtp.postmarkapp.com
Ports: 25, 2525, or 587
Username/Password: 209abebf-ce04-4c74-a2eb-fa70fe3035ca
Authentication: Plain text, CRAM-MD5, or TLS

```


### Open Office 

apt-get install openoffice.org
apt-get install openoffice.org-writer2latex


### Unoconv 

apt-get install unoconv


### UNP 

apt-get install unp 


### Paquetes adicionales de Open Office 

apt-get install openoffice.org-base openoffice.org-writer openoffice.org-calc openoffice.org-impress openoffice.org-draw openoffice.org-math openoffice.org-filter-mobiledev openoffice.org-filter-binfilter msttcorefonts pstoedit libpaper-utils ttf-dejavu


### Image Magick 

apt-get install imagemagick


### Servidor de Open Office 

Comprobar la versión de openoffice:
dpkg -l | grep openoffice

Posicionarse en cualquier directorio del servidor. Recomendado: /home/pptvivo
vim ooo.sh

Para la versión 3.3:

unset DISPLAY
/usr/lib/openoffice/program/soffice "--accept=socket,host=localhost,port=8100;urp;StarOffice.ServiceManager" --nologo --headless --nofirststartwizard

Para la versión 3.2:

Este script arranca el openoffice como servicio apuntando al localhost y puerto 8100. Contenido del archivo:
unset DISPLAY
/usr/lib/openoffice/program/soffice "-accept=socket,host=localhost,port=8100;urp;StarOffice.ServiceManager" -nologo -headless -nofirststartwizard

Guardar el archivo y asignarle permisos
chmod +x ooo.sh

Arrancar el server ooo como root
sh ooo.sh

Verificar si el servidor está corriendo:
netstat -an | grep 8100

El comando anterior mostrará algo como:
tcp 0 0 127.0.0.1:8100 0.0.0.0:* LISTEN

Verificar si el proceso de soffice está corriendo:
ps aux | grep soffice


### Script de Inicio de Open Office 

Crear y editar un archivo llamado openoffice.sh (por ejemplo) en /etc/init.d:

* Para la versión 3.3:

vim /etc/init.d/openoffice.sh

```
#!bash


#!/bin/bash
# openoffice.org  headless server script
#
# chkconfig: 2345 80 30
# description: headless openoffice server script
# processname: openoffice
# 
# Author: Vic Vijayakumar
# Modified by Federico Ch. Tomasczik
#
OOo_HOME=/usr/bin
SOFFICE_PATH=$OOo_HOME/soffice
PIDFILE=/var/run/openoffice-server.pid
set -e
case "$1" in
    start)
    if [ -f $PIDFILE ]; then
      echo "OpenOffice headless server has already started."
      sleep 5
      exit
    fi
      echo "Starting OpenOffice headless server"
      $SOFFICE_PATH --headless --nologo --nofirststartwizard --accept="socket,host=127.0.0.1,port=8100;urp" & > /dev/null 2>&1
      touch $PIDFILE
    ;;
    stop)
    if [ -f $PIDFILE ]; then
      echo "Stopping OpenOffice headless server."
      killall -9 soffice && killall -9 soffice.bin
      rm -f $PIDFILE
      exit
    fi
      echo "Openoffice headless server is not running."
      exit
    ;;
    *)
    echo "Usage: $0 {start|stop}"
    exit 1
esac
exit 0
```


* Para la versión 3.2:

vim /etc/init.d/openoffice.sh


```
#!bash

#!/bin/bash
# openoffice.org  headless server script
#
# chkconfig: 2345 80 30
# description: headless openoffice server script
# processname: openoffice
# 
# Author: Vic Vijayakumar
# Modified by Federico Ch. Tomasczik
#
OOo_HOME=/usr/bin
SOFFICE_PATH=$OOo_HOME/soffice
PIDFILE=/var/run/openoffice-server.pid
set -e
case "$1" in
    start)
    if [ -f $PIDFILE ]; then
      echo "OpenOffice headless server has already started."
      sleep 5
      exit
    fi
      echo "Starting OpenOffice headless server"
      $SOFFICE_PATH -headless -nologo -nofirststartwizard -accept="socket,host=127.0.0.1,port=8100;urp" & > /dev/null 2>&1
      touch $PIDFILE
    ;;
    stop)
    if [ -f $PIDFILE ]; then
      echo "Stopping OpenOffice headless server."
      killall -9 soffice && killall -9 soffice.bin
      rm -f $PIDFILE
      exit
    fi
      echo "Openoffice headless server is not running."
      exit
    ;;
    *)
    echo "Usage: $0 {start|stop}"
    exit 1
esac
exit 0

```

Cambiar los permisos del archivo
chmod 0755 /etc/init.d/openoffice.sh

Hacer que el script de openoffice arranque al inicio:
update-rc.d openoffice.sh defaults

Arrancar el servicio
/etc/init.d/openoffice.sh start

Verificar si esta corriendo:
netstat -nap | grep office

El comando anterior devolverá algo como esto:

```
#!bash

tcp        0      0 127.0.0.1:8100          0.0.0.0:* LISTEN     2467/soffice.bin 
```


El servicio de openoffice arrancará automáticamente en cada reinicio del servidor


### Script de Conversion de archivos 

Para poder pasar de un ppt a png, primero debemos hacer un paso previo de pasarlos a pdf. 
Para ello creamos un script llamado "image_converter" con las siguientes lineas:
Directorio recomendado para la creación: /home/pptvivo

vim image_converter.sh
	

```
#!bash

#Execution example: ./image_converter.sh /var/www/html/test/sample pptx pdf png
unoconv -f $3 $1.$2
convert  $1.$3  $1.$4
convert  $1.$3 -thumbnail 130x100 $1-small.$4
rm -rf $1.$3

Este script se ejecuta de la siguiente manera:

./image_converter.sh /var/www/html/test/sample pptx pdf png

;Argumentos:
;$1 --> Archivo origen sin extension
;$2 --> Extension del archivo origen
;$3 --> Extensión intermedia para convertir
;$4 --> Extensión final de salida

```

Explicación del script:

En la primera línea se le indica al comando unoconv que convierta al formato intermedio ($2) el archivo $1.$2 (nombre + extension)
En nuestro ejemplo, convierte el archivo sample.pptx al archivo sample.pdf

En la segunda línea se usa imagemagick para convertir el archivo intermedio ($1.$3) al formato final de salida ($1.$4) 
En nuestro ejemplo, convierte cada hoja del pdf en imágenes png separadas.

En la tercer línea hacemos lo mismo que en la línea anterior, pero para generar las miniaturas de las imágenes.

En la cuarta línea eliminamos el archivo intermedio generado. En nuestro ejemplo es el sample.pdf


### Plugin de Power Point 2007 

Descomprimir el archivo PPTVivoAddIn.rar en cualquier directorio.

Ejecutar el archivo setup.exe

Para probarlo, abrir cualquier archivo con extensión PPT o PPTX en Office Power Point 2007. 
En el menú debería aparecer una nueva opción con el nombre "PPT Vivo! Toolbar". Hacer click en la misma
Se mostrará un botón para realizar el login.
La sincronización de diapositivas sólo se realizará cuando el usuario se haya logueado satisfactoriamente y se haya obtenido la información de la exposición del día asociada a esa presentación.