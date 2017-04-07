<h1 align="center">ShoutItLouder - Loops</h1>

<p align="center">
<a href="https://travis-ci.org/benlipp/loops"><img src="https://travis-ci.org/benlipp/loops.svg" alt="Build Status"></a>
</p>

## Overview
A task management tool so SIL can see what stuff is pending, and have centralized management.

## Local Dev Environment
###### Initial Setup
Run:
````
composer install
./vendor/bin/homestead make
````
Edit Homestead.yaml file:
  - make sure you set your IP so it doesn't conflict with other VMs
  - set the url (and edit `/etc/hosts` or your DNS configuration as needed)
  
then run:
````
cp .env.example .env
````
Make relevant edits to .env.

Finally, run:
````
vagrant up
php artisan key:generate
php artisan migrate --seed
````
You should be up and running.

###### Subsequent Runs

A `vagrant up` should be all you need. Make sure you run `vagrant halt` if you are using multiple machines with the same IP address.

## Production
Heroku with a MySQL DB Addon

## License
All Rights Reserved (until further notice)
