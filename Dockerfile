FROM ubuntu:trusty
USER root
RUN apt-get update
RUN apt-get install -y nginx
RUN apt-get install -y php5-fpm
ADD nginx.conf /etc/nginx/nginx.conf
ADD www.conf /etc/php5/fpm/pool.d/www.conf

ADD sample /app
WORKDIR /app
EXPOSE 80

CMD /usr/sbin/php5-fpm \
  --daemonize \ 
  --fpm-config /etc/php5/fpm/php-fpm.conf \ 
  --allow-to-run-as-root && nginx -g 'daemon off;'

