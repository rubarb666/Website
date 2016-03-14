Welcome to Rhubarb
==================

Rhubarb is a PHP application development framework giving you a robust, fast and secure platform
for your next project.

```bash
composer create-project rhubarbphp/bootstrap-webapp myapp
```

## How does Rhubarb differ from other great frameworks like Laravel, Zend, Symphony and the others?

Rhubarb shares many of the best of these frameworks but improves in some important areas. Rhubarb
has been forged in the fire of real enterprise application development where performance and
development costs become big concerns.

Here's some of Rhubarb's key features:

### 1. Scaffolds

A Rhubarb scaffold can, just by including it, configure models, DB schemas, url handling and
user interfaces. After inclusion any aspect of those features can be amended, retired or even
completely replaced to best fit in your application.

### 2. Hierarchical MVP

Unique among PHP frameworks Rhubarb showcases a hierarchical Model-View-Presenter library for rapid
development of unit tested, view abstracted user interfaces through reusable objects.

### 3. Performance

We've learned the hard way how applications grow over time and we don't believe the performance
of your application should degrade as your application gets more complex. That's why we've made
[important decisions](/performance) about how Rhubarb is configured.

### 4. Configuration over Convention

Many frameworks have moved to 'convention over configuration' philosophies. If you name files
correctly and put them in the right location the behaviour you want will automatically emerge.
While this approach lets you demonstrate lots of progress quickly, in a real enterprise application
its not long before your requirements go beyond what simple convention can achieve and invariably
the framework starts working against you requiring fairly obscure to circumvent the automatic
behaviours. Junior developers are also afforded little opportunity to stretch their
programming skills as tasks can easily become simple assembly jobs, with a fall back of
searching the web for solutions to problems outside the 'magic' zone.

Rhubarb's approach is configuration over convention. This gives you the maximum performance
and helps people understand how the application works and thereby open the door to creative
and cost effective programming.

## Starting a Rhubarb project

Rhubarb contains a primary library ('rhubarb') and a collection of optional modules and scaffolds that you
can choose from. It requires [composer](https://getcomposer.org/) to manage these optional modules.

As we all know the best way to evaluate something is to see real examples so the best way to
get started might be to base your project on our bootstrap app:

```bash
composer create-project rhubarbphp/bootstrap-webapp myapp
cd myapp
vagrant up
```

We're using [vagrant](http://vagrantup.com/) to host Apache so you can now simply visit
[http://localhost:8080/](http://localhost:8080/)

