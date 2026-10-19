FROM nginx:alpine
WORKDIR /var/www/html

RUN rm /etc/nginx/conf.d/default.conf # под замену и чтоб наверняка

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
