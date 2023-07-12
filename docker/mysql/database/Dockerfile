FROM mysql:8.0.30

COPY ./my.cnf /etc/mysql/conf.d/
RUN mkdir /var/log/mysql && \
    chown mysql:mysql /var/log/mysql && \
    chmod 777 /etc/mysql/conf.d/my.cnf