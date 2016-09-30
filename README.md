# Shoe Locator #

#### Practice with many-to-many relationships in PHP and MySQL, September 30th, 2016

#### By Mark Lawson

## Description ##

This application is an exercise in PHP BDD testing with many-to-many relationships. Users can add/edit/delete stores and add shoe brands to each store. Users can also add new shoe brands and add stores that carry each brand. The application is built with PHP, using the Silex framework, Twig templates, and Bootstrap for styling.

## Setup/Installation Instructions ##

* Clone the repository
* Using the command line, navigate to the project's root directory
* Install dependencies by running $ composer install
* Sign into MySQL shell by running $ /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot
* Start MAMP server and go to MAMP preferences:
    * Set Document Root to project's root directory
    * In the app/app.php project file, make sure the $server variable points to the localhost port listed under Ports>MySQL port in MAMP
* In a browser, go to http://localhost/phpmyadmin
* Select Import from the top menu and choose the compressed .sql files from the projects root directory and click 'Go' to import the databases
* Navigate to the /web directory and start a local server with $ php -S localhost:8000
* Open a browser and go to the address http://localhost:8000 to view the application

## MySQL Setup

* CREATE DATABASE shoes;
* USE shoes;
* CREATE TABLE stores (id serial PRIMARY KEY, name VARCHAR (255));
* CREATE TABLE brands (id serial PRIMARY KEY, name VARCHAR (255));
* (copy database in phpmyadmin to create shoes_test)

## Specifications

* The program will save new stores
    * Example input: DSW
    * Example output: store 1

* The program will return all stores
    * Example input: DSW, Foot Locker
    * Example output: store 1, store 2

* The program will delete all stores
    * Example input: DSW, Foot Locker
    * Example output: false

* The program will return a specific store by id
    * Example input: 1
    * Example output: DSW

* The program will edit stores
    * Example input: DSW
    * Example output: DSW Outlet

* The program will delete specific stores
    * Example input: DSW
    * Example output: false

* The program will save new brands
    * Example input: Nike
    * Example output: brand 1

* The program will return all brands
    * Example input: Nike, Adidas
    * Example output: brand 1, brand 2

* The program will delete all brands
    * Example input: Nike, Adidas
    * Example output: false

* The program will return a specific brand by id
    * Example input: 1
    * Example output: Nike

* The program will return all brands of a specific store
    * Example input: Foot Locker
    * Example output: brand 1, brand 2

## Known Bugs ##

There are no known bugs at this time.

## Support and Contact Details ##

Please report any bugs or issues to mlawson3691@gmail.com.

## Languages/Technologies Used ##

* PHP
* Silex
* Twig
* PHPUnit
* Bootstrap

### License ###

*This application is licensed under the MIT license.*

Copyright (c) 2016 Mark Lawson
