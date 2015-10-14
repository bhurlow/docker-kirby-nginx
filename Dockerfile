FROM ubuntu:trusty
RUN apt-get update
RUN apt-get install -y nginx
RUN apt-get install -y php5-fpm
ADD nginx.conf /etc/nginx/nginx.conf
RUN mkdir /app
WORKDIR /app
EXPOSE 80
CMD /etc/init.d/php5-fpm start && nginx -g 'daemon off;'



