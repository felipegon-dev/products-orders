FROM httpd:2.4.29

# Disable Indexes
RUN sed -i "s/Options Indexes FollowSymLinks/Options FollowSymLinks/" /usr/local/apache2/conf/httpd.conf

#Load Module proxy_fcgi
RUN sed -i "s/#LoadModule proxy_module modules\/mod_proxy.so/LoadModule proxy_module modules\/mod_proxy.so/" /usr/local/apache2/conf/httpd.conf && \
    sed -i "s/#LoadModule proxy_fcgi_module modules\/mod_proxy_fcgi.so/LoadModule proxy_fcgi_module modules\/mod_proxy_fcgi.so/" /usr/local/apache2/conf/httpd.conf
RUN sed -i "s/#LoadModule rewrite_module modules\/mod_rewrite.so/LoadModule rewrite_module modules\/mod_rewrite.so/" /usr/local/apache2/conf/httpd.conf
#RUN a2enmod rewrite

# Virtual hosts
COPY ./config/vhost.conf /usr/local/apache2/conf/extra/httpd-vhosts.conf
RUN sed -i "s/#Include conf\/extra\/httpd-vhosts.conf/Include conf\/extra\/httpd-vhosts.conf/" /usr/local/apache2/conf/httpd.conf


WORKDIR /usr/local/apache2/htdocs
