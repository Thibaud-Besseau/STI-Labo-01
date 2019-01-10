# STI Projet 1

## HOW TO START

To launch this application, you must execute the following commands:
`docker run -ti -v "$PWD/site":/usr/share/nginx/ -d -p 8080:80 --name sti_project --hostname sti arubinst/sti:project2018` 

`docker exec -u root sti_project service nginx start` 

`docker exec -u root sti_project service php5-fpm start` 


After you need to execute theses commands on the container to install the mcrypt librairie:

```bash
docker exec -it sti_project /bin/bash
apt-get update
apt-get install php5-mcrypt
ln -s /etc/php5/conf.d/mcrypt.ini /etc/php5/mods-available/mcrypt.ini
php5enmod mcrypt
service php5-fpm restart
sudo service nginx restart
cd /usr/share/nginx
chmod 777 -R databases/
```

After that you can connect to `localhost:8080`.


For the moment, there are two accounts:


| Login                       |Password     | Role  |
|-----------------------------|-------------|-------|
| admin@sti.ch                | Admin       | Admin |
| thibaud.besseau@heig-vd.ch  | test        | User  |

