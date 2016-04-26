

Configure your local DNS. Edit the file `/etc/hosts`, and add the following line: 

    127.0.0.1   test-recrutement.com www.test-recrutement.com
    
Create an Apache virtual host. This is an example.

    <VirtualHost *:80>
        ServerName www.test-recrutement.com
        ServerAlias test-recrutement.com *.test-recrutement.com
        DocumentRoot "/Users/denisbeurive/Desktop/test-recrutement/www"
        <Directory />
        AllowOverride All
            Order Allow,Deny
            Allow from all
        </Directory>
        ErrorLog "/Users/denisbeurive/Desktop/test-recrutement/logs/error.log"
        CustomLog "/Users/denisbeurive/Desktop/test-recrutement/logs/access.log" common
    </VirtualHost>

Restart Apache.

Then, open `http://www.test-recrutement.com/views/register.php`.

