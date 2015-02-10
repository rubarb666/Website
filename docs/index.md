Welcome to Rhubarb PHP
======================

Rhubarb PHP is an application development framework allowing you a robust, fast and secure platform
for your next project.

## How does Rhubarb differ from other great frameworks like Laravel, Symphony 2 and Cake PHP?

Rhubarb shares much of the best of these frameworks but emphasises three main themes

1. Performance: Rhubarb rejects string parsing routes and filters in favour of object trees. Rhubarb
supports autoloading but tries to avoid it by requiring dependant classes. Rhubarb keeps the complexity
of framework features low reducing overall code paths to a minimum.

2. Modularity: A Rhubarb module can, just by including it, configure models, schemas, url handling and
presenters. And after inclusion any aspect of those features can be amended, retired or even completely
supplanted to best fit with your application.

3. MVP: Rhubarb showcases a Model-View-Presenter library (Leaf) that provides an excellent way to build
unit tested, view abstracted user interfaces through reusable objects.

## Switching on

To get started with Rhubarb you'll need composer. Once you have it, you can create your first Rhubarb
project by using composer's `create-project` command to bring down an application template. An application
template is a simple scaffold which sets you up with some example project files to get started.

```bash
composer create-project rhubarbphp/application.blog myblog
```

All of the application templates come with a Vagrantfile so if you have vagrant simply bring it up:

```bash
cd myblog
vagrant up
```

Now visit `http://myblog.127.0.0.1.xip.io:8080/` and you're up and running.