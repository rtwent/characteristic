psql --command "CREATE USER docker WITH SUPERUSER PASSWORD 'docker';" &&\
createdb -O docker docker

echo "host all  all    0.0.0.0/0  md5" >> /etc/postgresql/10.14/main/pg_hba.conf

echo "listen_addresses='*'" >> /etc/postgresql/10.14/main/postgresql.conf