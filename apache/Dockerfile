FROM webdevops/php-apache:8.2

WORKDIR /tmp/

COPY ./run_script  /tmp/
CMD /tmp/run_script
RUN chmod +x run_script

WORKDIR /var/www/html
RUN apt update
RUN apt-get install sendmail -y 