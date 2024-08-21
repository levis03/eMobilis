# Step 1: Use an official PHP image with Apache as a base
FROM php:8.1-apache

# Step 2: Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Step 3: Copy your application code to the container
COPY . /var/www/html/

# Step 4: Set permissions on the copied files (optional)
RUN chown -R www-data:www-data /var/www/html

# Step 5: Expose port 80
EXPOSE 80

# Step 6: Start Apache in the foreground (default behavior in the base image)
CMD ["apache2-foreground"]

