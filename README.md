README
======

A means of working out what to drink.

## Getting Started

You'll need VirtualBox, Vagrant (v1.1+) and Composer.

 1. Check out the code and `vagrant up`.
 2. `composer install`
 3. `vagrant ssh` then `cd /vagrant` then `mysql -u root -p < schema.sql`. The password is `password`. 
 4. Visit `http://localhost:8080`

Test data is somewhat limited at present, but try typing in a few ingredients like, say, Lime Juice, Soda Water and White Rum. Follow that with a Long Island Iced Tea and you should hit your target.


