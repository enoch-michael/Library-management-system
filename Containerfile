FROM registry.access.redhat.com/ubi9/php-82 

LABEL description="Library Manangement System"

ENV DB_HOST=lib-database-conn \
    DB_USER=lib \
    DB_PASS=libpass \
    DB_NAME=library_db 

COPY --chown=1001:0 . /opt/app-root/src/

EXPOSE 8080 

USER 1001 
