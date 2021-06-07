# AjdainiPHP - PHP Framework
The AjdainiPHP Framework is still very recent, but there are enough features to implement it in your projects and it fully respects the MVC (Model-View-Controller) structure. 

## How to make our Framework work locally ?
Before importing our framework into your machine, please be sure to install and respect the prerequisites listed below :

## Prerequisites
* Have installed [Composer](https://getcomposer.org/download) (Composer is a free dependency management software written in PHP)
* Have a PHP version [7.3](https://www.php.net/downloads.php) or higher

## Installing dependencies 
With the file ``compose.json`` it will give you all the necessary dependencies to run the site, first place yourself in the root directory, then run the following command:

* ``composer install`` (it should normally install a ``vendor`` folder)

## Test our sample files 
To test our sample files, you should first insert the following SQL code into your terminal when you are connected to your MYSQL account.

```sql
CREATE DATABASE sample_db;

CREATE TABLE sample_db.sample 
(
    id_spl INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    date_added DATETIME NOT NULL
);
```

## How is our Framework structured ?

First of all in the root of the folder you will find the file ``compose.json`` which returns in json form all the packages used by our framework. It is also through this file that you were able to install in a single command the packages necessary to run our framework. You will also find an ``.env`` file allowing you to insert environment constants to be referred to from the different configurations of the project. There are generally some sensitive variables that should not be seen by anyone, that's why it's advisable to ignore this file by inserting it in the ``.gitignore`` file before your GIT repository and to provide an ``.env.sample`` file (the filename is just an example) where you define the same environment variables with fictitious values so that another developer doesn't have to guess them by himself. We have provided an ``.env`` file where you will find environment variables that are used to connect to the database so you have to insert your informations first. Normally after running the requested commands you will find a /vendor folder where it has all the necessary packages to run the Framework. So in the /src folder you will find all the classes that are part of the AjdainiPHP Framework.

### Controller
By using the controllers you can focus on the logic of your code without having to merge with the code of your view. You could analyze your data and make modifications, manage the requests of the page made by the user, manage the access rights, ... 

### ORM
We have done our best to make it easy for you to access databases and send queries by using the notion of ORM (Object-Relation Mapper). This means that you would no longer need to rewrite SQL code each time but simply use methods with all the predefined SQL code that will adapt to any table in a database and you would only have to call them and pass them parameters to adapt it to your needs.

### Table
In our case you will find the four basic operations for data persistence called CRUD operation (create, read, update, delete) but you can also bring your own methods if you want to write more complex or specific SQL code to your table. The only limitation for the moment is that we only support 2 drivers (MySql, PostGres) but the main advantage is that you can change the driver whenever you want without worrying about compatibility.

### Entity
With the help of your entity classes that inherit our Entity class you could manipulate and persist your data in the form of an object which is the main advantage that drive us to use the ORM notion. Here is a small example to clarify things for you: $user->getUsername() & $user->setUsername('Julie'). By manipulating your data with objects you would have total freedom to manage the rendering of your data in your methods and impose limitations on your users. 

### Template
We were able to develop our own Template class that you could implement in your page views. The advantage of using ours is that you can use blocks with a specific buffer name that will be passed as an argument and then add your content inside before the block ends. Your content will then be stored and replaced by the variable in your template page which will have the same name as your buffer passed previously as argument.

### Http
You have the possibility to use our Session & Cookie Class to keep track of the requests made to the server. The advantage is that we manage all the technical and security aspects. We encourage you to use our Class Session which is very advanced and has several useful methods but also in terms of security through our secureSession method you will be able to avoid XSS attacks and therefore avoid that an ordinary user is stolen by a cybercriminal.

### Config
Our Class Config allows you to manage all your configuration files under a single class. The config files must return an array to be processed by our class and only files with ``.php`` & ``.ini`` extension are accepted. 
