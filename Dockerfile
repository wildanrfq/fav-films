FROM php:8.2-apache

# Enable Apache mod_rewrite for WordPress permalinks
RUN a2enmod rewrite

# Set document root
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html/

# Set proper permissions for Apache & SQLite database
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/wp-content/database

# Configure Apache port for Cloud PaaS (Render, Railway, etc.)
ENV PORT=80
EXPOSE 80

CMD ["apache2-foreground"]
