FROM registry.access.redhat.com/ubi9/php-82 

LABEL description="Library Manangement System"

ENV DB_HOST=lib-database-pod \
    DB_USER=lib \
    DB_PASS=libpass \
    DB_NAME=library_db \
    PHP_CLEAR_ENV=OFF

USER 0
COPY --chown=1001:0 . /tmp/src
USER 1001

RUN /usr/libexec/s2i/assemble

EXPOSE 8080 

USER 1001 

CMD ["/usr/libexec/s2i/run"]
