Tutorial: An example Rhubarb project
====================================

Like any programmer you're itching to get started so let's work on a real example and we'll learn
about the basics of Rhubarb along the way.

## Starting a project

You can also manually create and edit a composer file if you wish but it's simpler to use composer to
initialise the project with the Rhubarb library.

``` bash
composer create-project rhubarbphp/bootstrap-webapp blog
```
The **bootstrap-webapp** project is a bootstrap project which will get us started. Also as you might have spotted
we're going to create a blog application. We'll build an engine to display blog articles and an admin to control it.

Once composer has finished you should have the following files and folders:

settings/app.config.php
:   The file which configures our application by chosing providers, setting up URL handlers, registering
schemas etc.

settings/site.config.php
:   A configuration file which controls site specific settings such as database credentials, logging levels
and developer mode. This file shouldn't be commited to your repository as it should be unique to each installed
location. By default this file is added to the project's .gitignore file.

vendor/rhubarbphp/rhubarb/
:   The rhubarb library. The vendor folder is where composer installs libraries.

src/
:   The location for your application's class files

src/Layouts/DefaultLayout.php
:   A very simple layout to get us started.

tests/
:   The location for your application's unit tests.

Vagrantfile
:   A vagrant setup ready to run your application

vagrant/
:   Supporting files for the vagrant installation

composer.json
:   Composers configuration file where you can require additional libraries

## Starting the application

Simply start the project with:

``` bash
vagrant up
```

Once vagrant has done it's work, you can visit the site by going to http://localhost:8080/

If you're used to using vagrant you will know that switching between projects that are all addressed
by `localhost` can be a problem so we recommend using the xip.io DNS service to keep URL history
and browser cache separate for a happier life. Visit http://blog.127.0.0.1.xip.io:8080/ and you
will end up at the same place.

## Breaking the ice - hello world

