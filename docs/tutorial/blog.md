Tutorial: Building a blog
==========================
# Initial Setup
You will need to install the following globally:
* git
* Composer
* docker and docker-compose
 
You should then run the following commands from the project root to get started
```bash
git clone https://github.com/RhubarbPHP/Bootstrap.WebApp.git
cd Bootstrap.WebApp
composer install #Download PHP Dependencies
docker-compose up #Start Virtual Machine
./custard.sh stem:seed-data #Seed some test blog articles.
```

Note that docker sets up the site to run on port 8080 which can sometimes conflict with the
ports that other applications such as Skype use. 

You will notice that a vendor directory has been created, this is where all of the third party
dependencies are stored.
 
This is contains all of the executables.

# Where is the home page?
If you open your browser at localhost:8080 you will find the "Welcome to Compost Corner!" start page.

Rhubarb uses a Model-View-Presenter pattern so, in `src/Leaves/Index` you will find a Leaf (Presenter), a Model and 
View: Index, IndexModel and IndexView.

Open IndexView.php and change "Welcome to Compost Corner!" to the obligatory text " Hello, World!".

You will find that the home page text has changed.

In `Index.php` you will notice that the Leaf class has been extended and that two methods:
`getViewClass()` and `createModel()` have been overridden. You must implement these abstract
methods and return what they are expecting every time. 

`getViewClass()` expects a string to be returned of the View class that you have created.
`createModel()` expects you to return a new `LeafModel` class that you have extended.

# Create an about us page
Create a new Directory in the `src/Leaves` directory called `AboutUs`. Inside this directory create 3 php files:
`AboutUs.php`, `AboutUsModel.php`, `AboutUsView.php`

## AboutUs.php
Add a namespace to `AboutUs.php`: 

`namespace Your\WebApp\Leaves\AboutUs;`

(Quick explanation of namespaces: The src directory is `Your\WebApp`, `\Leaves\` is the Leaves directory and the 
`AboutUs` part of the namespace is the `AboutUs`directory that we created. This is to allow the composer autoloader to 
find our classes.)

Add a class called `AboutUs` which `extends \Rhubarb\Leaf\Leaves\Leaf`. For convenience you can add a use statement to 
shorten this. Your file will now look like this.

```php
<?php

namespace Your\WebApp\Leaves\AboutUs;

use Rhubarb\Leaf\Leaves\Leaf;

class AboutUs extends Leaf
{
}
```

Those of you using an IDE will notice that the class declaration is showing an error because we need to 
implement/override two methods. Lets leave that until we create the other two classes so we can use them here.

In `AboutUsModel.php` add the same namespace as before and your class declaration should be as follows:

`class AboutUsModel extends \Rhubarb\Leaf\Leaves\LeafModel`

You can simplify this with a use statement.

In `AboutUs.php` implement/override the `createModel()` method and return a new `AboutUsModel()`

```php
protected function createModel()
{
    return new AboutUsModel();
}
```

In `AboutUsView.php` add the namespace as before, and add the class declaration as follows:

(At this point I will assume that you will automatically switch to the use statements)

`class AboutUsView extends \Rhubarb\Leaf\Views\View`

In this class for now, implement/override `printViewContent()` so that we will have something to display
```php
protected function printViewContent()
{
    ?>
    <h1>About Us</h1>
    <p>This is a blog site created using RhubarbPHP.</p>
    <?php
}
```

You can also use `print "Your content";` if you prefer, instead of opening and closing php.

In `AboutUs.php` we can now implement/override that last method: `getViewClass()`. We need to return the class name 
of our view class.
```php
protected function getViewClass()
{
    return AboutUsView::class;
}
```

the last thing that we need to do is register our leaf `AboutUs` in the main YourApplication class. You will find this 
in the `src/` directory: `YourApplication.php`

You will find a `registerUrlHandlers()` method, which calls a method `$this->addUrlHandlers();`

This method accepts an array of url handlers. You will find the index one here already. Add an array to as the second 
parameter to `ClassMappedUrlHandler` and add a key value pair of "about-us/" => new classMappedUrlHandler(AboutUs::class)

If that seems daunting, just copy this for now.

```php
protected function registerUrlHandlers()
{
    parent::registerUrlHandlers();
    $this->addUrlHandlers(
        [
            "/" => new ClassMappedUrlHandler(Index::class,
                [
                    "about-us/" => new ClassMappedUrlHandler(\Your\WebApp\Leaves\AboutUs\AboutUs::class)
                ])
        ]
    );
}
```

You will add all of your new Pages to this array. All page names should end with a /
`http://localhost:8080/about-us/` is the url where we will now find the page.

## If that seemed like a lot of work
For those of you using JetBrains PhpStorm IDE:<br>
There is a plugin called 'Compost' that can speed up the process.

It can be found by searching in PhpStorms Preferences/Plugins marketplace. Don't worry, it's free.

Once installed and PhpStorm is restarted, the option to make a new Rhubarb Leaf and Model are available through the 
normal process of making any new class or file.

If we create a new Rhubarb Leaf , the 'Add a new Leaf set' window appears. This will auto-name and create the Model, 
View and ViewBridge (if required) based on the Leaf name. The new files will include a lot of helpful comments. 

# Databases & tables

We need to require the Stem module to the project. In the project root enter the following command:

`composer require rhubarbphp/module-stem`

This will update your `composer.json` and your `composer.lock` files. In `YourApplication.php` we will need to register 
the Stem module. In `getModules()` add `new \Rhubarb\Stem\StemModule()`

Create a `Models` directory in `src/` In here you will need to create a `SolutionSchema` class and a Model class for each 
table of your database.


## Post Table
In the `Models` directory create a new php file called `Post.php`.
Give it a namespace: `namespace Your\WebApp\Models;`
it needs to contain a class as follows:

`class Post extends \Rhubarb\Stem\Models\Model`

In `createSchema()` set it up to look like this:

```php
protected function createSchema()
{
    $schema = new \Rhubarb\Stem\Schema\ModelSchema("Post");
    
    $schema->addColumn(
        new \Rhubarb\Stem\Schema\Columns\AutoIncrementColumn("PostID"),
        new \Rhubarb\Stem\Schema\Columns\StringColumn("Title", 50),
        new \Rhubarb\Stem\Schema\Columns\LongStringColumn("Content")
    );
    
    $schema->labelColumnName = "Title";
    
    return $schema;
}
```

All we are doing here is defining the columns in the table, and setting the labelColumnName which will be useful later.

## Register the table in a SolutionSchema

In the Models directory create a new file called `YourApplicationSolutionSchema.php`.

Give it the same namespace as before, and add a class declaration as follows:

`class YourApplicationSolutionSchema extends \Rhubarb\Stem\Schema\SolutionSchema`

You will need to override the constructor, call the parent and use the `addModel()` method for our table as follows:

```php
public function __construct($version = 0)
{
    parent::__construct($version);
    $this->addModel("Post", Post::class);
}
```

## Register the SolutionSchema
First, have a look in the settings directory to see that vagrant has copied in a file called site.config.php with your
database credentials. When you move to a live server you should create this file for yourself with your secure
credentials. For our purposes in local development, this is sufficient.

In `YourApplication.php` we need to register our SolutionSchema.

Override the `initialise()` method, and call the parent.

In this method, you will need to include `site.config.php`, register the SolutionSchema and set the default repository class name to the mysql 
repository as follows:

```php
protected function initialise()
{
    parent::initialise();
    
    if(file_exists(APPLICATION_ROOT_DIR . "/settings/site.config.php")){
        include_once(APPLICATION_ROOT_DIR . "/settings/site.config.php");
    }
    
    \Rhubarb\Stem\Schema\SolutionSchema::registerSchema("YourApplicationSolutionSchema", \Your\WebApp\Models\YourApplicationSolutionSchema::class);
    \Rhubarb\Stem\Repositories\Repository::setDefaultRepositoryClassName(\Rhubarb\Stem\Repositories\MySql\MySql::class);
}
```

Now ssh into vagrant using `vagrant ssh` and do the following:

```bash
cd /vagrant 
vendor/bin/custard stem:update-schemas
```

You will now have a database created with a Post table. While we are in here, we can also use the handy document command
to give us PhpDoc comments to improve intellisense.

```bash
vendor/bin/custard stem:document-model
0
```
Select your schema `0` and press enter
You will find comments have been added to `Post.php`, and a Post table has been created in your vagrant database.

If you are connecting to the database with HeidiSQL,Sequel Pro etc you will find the vagrant database in this example
running on `localhost:3307` with username `vagrant` and password `vagrant`. We have chosen port 3307 so that a local 
database will not be affected.

Details of ports can be found in the `Vagrantfile` and database details in `vagrant/provision.sh` should you need to 
modify these to avoid ports colliding etc.

# Display Posts from database
Using your database viewer of choice, manually add a few new posts in the database with a title and some lorem ipsum 
text for the content or whatever you want.

We will now display these posts on the HomePage.

Open `IndexView.php`.

In the `printViewContent()` method, lets create a variable of all of the posts and loop over them and print each of them 
out.

```php
protected function printViewContent()
{
    parent::printViewContent();
    ?>
    <h1>Rhubarb Blog</h1>
    <?php
    
    $posts = \Your\WebApp\Models\Post::all();
        foreach ($posts as $post) {
    ?>
        <h2><?= $post->Title ?></h2>
        <p><?= $post->Content ?></p>
    <?php
    }
}
```

# CRUD (Create Read Update Delete) Posts
first you will need to add a few dependencies:
```bash
composer require rhubarbphp/module-leaf-crud
composer require rhubarbphp/module-leaf-common-controls
composer require rhubarbphp/module-leaf-table
```
in `src/Leaves` create a new directory called `Posts`
Create the following 4 files: `PostsCollection.php`, `PostsCollectionView.php`, `PostsItem.php` and `PostsItemView.php`

They each need a namespace: `namespace: Your\WebApp\Leaves\Posts` and they each need a class with the same as their file name

## Table of Posts

`PostsCollection` and `PostItem` both ned to extend `\Rhubarb\Leaf\Crud\Leaves\CrudLeaf`.
You will need to return the correct View class name for each of these.
`PostCollectionView` and `PostItemView` both need to extend `\Rhubarb\Leaf\Crud\Leaves\CrudView`. You don't need to 
override createModel this time until you need to.

In `PostCollectionView` override the `createSubleaves()` method as follows.

```php
protected function createSubLeaves()
{
    parent::createSubLeaves();
    $this->registerSubLeaf(
    $table = new \Rhubarb\Leaf\Table\Leaves\Table(\Your\WebApp\Models\Post::all(), 50, "PostsTable")
);

    $table->columns =
    [
        "Title",
        "Edit" => '<a href="/posts/{PostID}/">edit</a>'
    ];
}
```

The first thing that happens is we use `registerSubLeaf()` this can take multiple leaves at a time separated by a comma.
We create a Table and set it's collection to `Post::all()`, the page size to 50 and the presenter name to "PostsTable"
We assign our Table Leaf to `$table` and then set the columns to an array of what we want to display.
The first column in the table we want to display is the Post `Title`. This is case sensitive and must be exactly as
is in `Post.php`. 
To show the parsing feature, I have put the link to the edit page as the second column in the table. Note that {PostID} 
is inside curly braces. This will be parsed into the `PostID` for the current row that is being displayed.


We then need to print out this table in `printViewContent()` as well as a link to the add page

```php
protected function printViewContent()
{
    parent::printViewContent();
    
    print '<a href="/posts/add/">add</a><br>';
    print $this->leaves["PostsTable"];
}
```

## Create, Update & Delete Posts
In `PostsItemView.php` again override `createSubLeaves()` and `printViewContent()`

In non-`CrudView`s, we would manually create a new `TextBox` leaf etc however, Rhubarb can work out the best html element
to display our database content. All we need to do is pass in a string of each of the columns that we want to be able
to access to edit. If you want something more custom, you can still do this here but remember to set it's name to the 
column name. The parent call to createSubLeaves() creates a `Save`, `Cancel` and `Delete` button for us.

Copy this in to save time:

```php
protected function createSubLeaves()
{
    parent::createSubLeaves();
    $this->registerSubLeaf(
    "Title",
    "Content"
);
}

protected function printViewContent()
{
    print $this->leaves["Title"];
    print "<br>";
    print $this->leaves["Content"];
    print "<br>";
    print $this->leaves["Save"];
    print $this->leaves["Cancel"];
    print $this->leaves["Delete"];
}
```


## Crud Url Handlers
Open `YourApplication.php` and modify the `registerUrlHandlers` method to look like this:

```php
protected function registerUrlHandlers()
{
    parent::registerUrlHandlers();
    $this->addUrlHandlers(
        [
            "/" => new ClassMappedUrlHandler(Index::class,
            [
                "about-us/" => new ClassMappedUrlHandler(AboutUs::class),
                "posts/" => new \Rhubarb\Leaf\Crud\UrlHandlers\CrudUrlHandler(\Your\WebApp\Models\Post::class, \Rhubarb\Crown\String\StringTools::getNamespaceFromClass(\Your\WebApp\Leaves\Posts\PostsCollectionView::class))
            ])
        ]
    );
}
```

If you visit http://localhost:8080/posts/ you should now see a link to add a post, a table with two titles and the Posts
that you created earlier. You can add and delete posts from here.

# Static files (CSS & Images)
The design conscious among you may be wondering about the location of the `<head>` tag to reference a css file etc, 
also where to put a css file. 

Static files go in the `static` directory in the project root. In this directory you will find `css/base.css` where you
can add custom styles. Lets add a font family to the existing body:

```css
body {
    margin: 0;
    font-family: sans-serif;
}
```

Open `src/Layouts/DefaultLayout.php` and add the reference to the css file in the `<head>` like this

```html
<link rel="stylesheet" href="/static/app.css">`
```

Images can be referenced from the same folder.
