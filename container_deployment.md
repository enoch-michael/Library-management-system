podman-compose up -d --build
podman ps                                    # both containers Up
podman logs lib-database-pod                 # look for "ready for connections"
podman exec lib-database-pod mysql -ulib -plibpass library_db -e "SHOW TABLES;"
curl -I http://localhost:8080                # expect HTTP 200 or 302