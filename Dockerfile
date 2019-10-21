FROM dzamyatin/php73-1.0.11

COPY app /var/www/html

WORKDIR /var/www/html

RUN ["composer", "install"]