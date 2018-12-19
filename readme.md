# STI Projet 1

## HOW TO START

To launch this application, you must execute the following commands:
`docker run -ti -v "$PWD/site":/usr/share/nginx/ -d -p 8080:80 --name sti_project --hostname sti arubinst/sti:project2018` 

`docker exec -u root sti_project service nginx start` 

`docker exec -u root sti_project service php5-fpm start` 


After that you can connect to `localhost:8080`.


For the moment, there are two accounts:


| Login                       |Password     | Role  |
|-----------------------------|-------------|-------|
| admin@sti.ch                | Admin       | Admin |
| thibaud.besseau@heig-vd.ch  | test        | User  |

