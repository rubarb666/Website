Welcome to Rhubarb
==================

Rhubarb is an application development framework allowing you a robust, fast and secure platform
for your next project.

## What features does Rhubarb offer?

* The best developer experience in extensible, modular system design via 'scaffolds'
* A full ORM system using the 'stem' module
* An event based M-V-P pattern user interface building framework in the 'leaf' module
* A service locator pattern through 'providers' to allow for decoupling of dependencies such as database,
 email sending, exception handling, encryption, hashing, logging etc.

## How does Rhubarb differ from other great frameworks like Laravel, Symphony 2 and Cake PHP?

Rhubarb shares must of the best of these frameworks but focuses on some important areas:

1. Modularity: A Rhubarb module can, just by including it, configure models, schemas, url handling and
user interfaces. And after inclusion any aspect of those features can be amended, retired or even completely
supplanted to best fit with your application.

2. MVP: Rhubarb showcases a Model-View-Presenter library that provides an excellent way to build
unit tested, view abstracted user interfaces through reusable objects.

3. Performance: Rhubarb supports autoloading (via composer) but tries to avoid it by requiring dependant classes.
Rhubarb rejects string based routing and model filtering in favour of simple object trees. Rhubarb keeps the
complexity of framework features low reducing overall code paths to a minimum. Rhubarbs logging system allows
for the generation of context data to be deferred until a logger actually commits to logging the message. These
are just some examples of how we've specifically focused on speed as a primary concern.

## Starting a Rhubarb project

Rhubarb contains a primary library ('rhubarb') and a collection of optional modules and scaffolds that you
can choose from. It requires [composer](https://getcomposer.org/) to download and install these optional modules
so the best way to start your project is using composer.

```bash
composer create-project rhubarbphp/bootstrap-webapp myapp
cd myapp
vagrant up
```

Now visit http://myapp.127.0.0.1.xip.io:8080/

