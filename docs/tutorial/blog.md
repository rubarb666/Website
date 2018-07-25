[Building a blog](/tutorial/blog)

Tutorial: Building a blog
==========================
# Initial Setup
You will need to install the following globally:
* git
* [Composer](https://getcomposer.org/download/)
* [Oracle Virtual Box (Required by Vagrant)](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant](https://www.vagrantup.com/downloads.html)

Run the following commands to create the base project and get started:
```bash
composer create-project rhubarbphp/bootstrap-webapp blog
cd blog
vagrant up #Start Virtual Machine
```

# Where is the homepage?
Open your browser at [localhost:8080](http://localhost:8080), you will find the "You're up and running!" start page.

Rhubarb uses a Model-View-Presenter pattern so, in `src/Leaves` you will find a Leaf, a Model and 
View: `Index`, `IndexModel` and `IndexView`.

Open `IndexView.php` and change "You're up and running!" to the obligatory text "Hello, World!".

Refresh the page and you will find that the homepage text has changed to "Hello World!".

# Create an about us page
> There is a shortcut for creating leaves later in this tutorial
Create a new directory in `src/Leaves`  called  `AboutUs`. Inside this directory create 3 php files:
`AboutUs.php`, `AboutUsModel.php`, `AboutUsView.php`

## AboutUs.php
Add a namespace to `AboutUs.php`: 

`namespace Your\WebApp\Leaves\AboutUs;`

> (Quick explanation of namespaces: The src directory is `Your\WebApp`, `\Leaves\` is the Leaves directory and the 
> `AboutUs` part of the namespace is the `AboutUs` directory that we created. This is to allow the composer autoloader to 
> find our classes.). Namespaces are configured in the `composer.json` file.

After the namespace, add a class called `AboutUs` which `extends \Rhubarb\Leaf\Leaves\Leaf`. For convenience, you can add a `use` statement to 
shorten this. Your file will now look like this.

```php
<?php

namespace Your\WebApp\Leaves\AboutUs;

use Rhubarb\Leaf\Leaves\Leaf;

class AboutUs extends Leaf
{
}
```

Those of you using an IDE will notice that the class declaration is showing an error because we need to override two 
methods. Let's leave that until we create the other two classes so we can use them here.

In `AboutUsModel.php` add the same namespace as before and your class declaration should be as follows:

`class AboutUsModel extends \Rhubarb\Leaf\Leaves\LeafModel`

You can simplify this with a `use` statement.

In `AboutUs.php` override the `createModel()` method and return a new `AboutUsModel()`

```php
protected function createModel()
{
    return new AboutUsModel();
}
```

In `AboutUsView.php` add the namespace as before, and add the class declaration as follows:

> (At this point I will assume that you will automatically switch to the `use` statements)

`class AboutUsView extends \Rhubarb\Leaf\Views\View`

In this class for now, override `printViewContent()` so that we will have something to display
```php
protected function printViewContent()
{
    ?>
    <h1>About Us</h1>
    <p>This is a blog site created using RhubarbPHP.</p>
    <?php
}
```

You can also use `print "Your content";` if you prefer, instead of opening and closing php tags.

In `AboutUs.php` we can now override that last method: `getViewClass()`. We need to return the class name of our view class.
```php
protected function getViewClass()
{
    return AboutUsView::class;
}
```

The last thing that we need to do is register our Leaf `AboutUs` in the Application class in `src/YourApplication.php`. 

You will find a `registerUrlHandlers()` method, which calls a method `$this->addUrlHandlers();`

This method accepts an array of `UrlHandler`s. You will find the `Index` Leaf registered here already. 
Add an array to as the second parameter to `ClassMappedUrlHandler` and add a key value pair 
of `"about-us/" => new classMappedUrlHandler(AboutUs::class)`

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

You will add all of your new pages to this array. For convenience, all page names should end with a /
[http://localhost:8080/about-us/](http://localhost:8080/about-us/) is the URL where we will now find the page.

## If that seemed like a lot of work
Rhubarb uses Custard commands to speed up the process of a lot of repetitive tasks.

Create a directory as follows:
`mkdir src/Leaves/QuickQuestions`
then ` cd src/Leaves/QuickQuestions`

then run the create leaf Custard command:
`../../../vendor/bin/custard leaf:create-leaf`
type in `QuickQuestions`  and press enter. 
The command it will create a Leaf, Model and View with a lot of helpful comments.

This page can be added to our `UrlHandler`s, as follows:

```php
$this->addUrlHandlers(
    [
        "/" => new ClassMappedUrlHandler(Index::class,
            [
                "about-us/" => new ClassMappedUrlHandler(\Your\WebApp\Leaves\AboutUs\AboutUs::class),
                "quick-questions/" => new ClassMappedUrlHandler(\Your\WebApp\Leaves\QuickQuestions\QuickQuestions::class)
            ])
    ]
);
```

# Databases & tables

Create a `Models` directory in `src/` In here you will need to create a `SolutionSchema` class and a Model class for each 
table of your database. This will be explained in a moment.


## Post Table
In the `Models` directory create a new php file called `Post.php`.
Give it a namespace: `namespace Your\WebApp\Models;`
it needs to contain a class as follows:

`class Post extends \Rhubarb\Stem\Models\Model`

You must override  `createSchema()` set it up to look like this:

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

All we are doing here is defining the name of the table, the columns in the table and setting the labelColumnName which will be useful later.

> A common pitfall is forgetting to return `$schema` at the end of the method.

## Register the table in a SolutionSchema

In the Models directory create a new file called `YourApplicationSolutionSchema.php`. Please note that the name of the class
does not matter, in RhubarbPHP configuration over convention is preferred. If you prefer, you could name this BlogSolutionSchema.

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
> Any time you make a change to any of the models in the schema, you must increase the version number to ensure that the tables 
> update to reflect the change. Columns will never be removed by this process.

## Register the SolutionSchema

In `YourApplication.php` we need to register our SolutionSchema.

In the `initialise()` method, add the two bottom lines to register the solution schema and to tell Rhubarb that you want to use MySQL as a database.

```php
protected function initialise()
{
    parent::initialise();

    $this->developerMode = true;
    if(file_exists(APPLICATION_ROOT_DIR . "/settings/site.config.php")){
        include_once(APPLICATION_ROOT_DIR . "/settings/site.config.php");
        }
    
    \Rhubarb\Stem\Schema\SolutionSchema::registerSchema("YourApplicationSolutionSchema", \Your\WebApp\Models\YourApplicationSolutionSchema::class);
    \Rhubarb\Stem\Repositories\Repository::setDefaultRepositoryClassName(\Rhubarb\Stem\Repositories\MySql\MySql::class);
}
```

ssh into vagrant using `vagrant ssh` and do the following:

```bash
cd /vagrant
vendor/bin/custard stem:update-schemas
```

You will now have a database created with a Post table. While we are in here, we can also use the handy document command
to give us PhpDoc comments to improve intellisense.

```bash
vendor/bin/custard stem:document-model
```
Select your schema `0` and press enter
You will find comments have been added to `Post.php`, and a Post table has been created in your vagrant database.

> If you are connecting to the database with HeidiSQL, SequelPro etc you will find the vagrant database in this example
> running on `localhost:3307` with username `vagrant` and password `vagrant`. We have chosen port 3307 so that a local 
> mySQL database will not be affected.
> Details of ports can be found in the `Vagrantfile` and database details in `vagrant/provision.sh` should you need to 
> modify these to avoid ports colliding etc.

# Display Posts from the database
Using your database viewer of choice, manually add a few new posts in the database with a title and some [lorem ipsum](https://lipsum.com/) 
text for the content or whatever you want.

We will now display these posts.

Open `IndexView.php`.

In the `printViewContent()` method, let's create a variable of all of the posts and loop over them and print each of them 
out.

```php
protected function printViewContent()
{
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
You will need to add a few dependencies:
```bash
composer require rhubarbphp/module-leaf-crud
composer require rhubarbphp/module-leaf-common-controls
composer require rhubarbphp/module-leaf-table
```

in `src/Leaves` create a new directory called `Posts`

Create the following 4 files: `PostsCollection.php`, `PostsCollectionView.php`, `PostsItem.php` and `PostsItemView.php`

They each need a namespace: `namespace Your\WebApp\Leaves\Posts;` and they each need a class with the same as their file name

`PostsCollection` and `PostItem` both ned to extend `\Rhubarb\Leaf\Crud\Leaves\CrudLeaf`.
You will need to return the correct View class name for each of these (Same as we did when we created the `Index` Leaf).
`PostCollectionView` and `PostItemView` both need to extend `\Rhubarb\Leaf\Crud\Leaves\CrudView`. 

> `createModel()` does not need to be overridden this time, however, if you need to raise custom events from the `View` 
> you will need to do so. It must extend `Rhubarb\Leaf\Crud\Leaves\CrudModel`.

## Table of Posts

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

The first thing that we did is we use the `registerSubLeaf()` method which can take multiple Leaf classes at a time separated by a comma.
We create a `Table` and set it's `Collection` to `Post::all()`, the page size to 50 and the Leaf name to "PostsTable".
We assign our `Table` Leaf to `$table` and then set the columns to an array of what we want to display.
The first column in the table we want to display is the Post `Title`. This is case sensitive and must be exactly as is in `Post.php`.

> To show the parsing feature, I have put the link to the edit page as the second column in the table. Note that {PostID} 
> is inside curly braces. This will be parsed into the `PostID` for the current row that is being displayed.

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

> In non-`CrudView`s, we would manually create a new `TextBox` leaf, however, Rhubarb can guess the correct HTML element
> to display our database content based on the type of column. All we need to do is pass in a string of each of the 
> columns that we want to be able to access to edit. If you want something more custom, you can still do this here 
> but remember to set its name to the column name. The parent call to createSubLeaves() 
> creates a `Save`, `Cancel` and `Delete` button for us.

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

If you visit [http://localhost:8080/posts/](http://localhost:8080/posts/) you should now see a link to add a post, 
a table with two titles and the Posts that you created earlier. You can add and delete posts from here.

> There is a custard command to create crud pages, `vendor/bin/custard leaf:create-crud-leaf`. You need to 
> Register the CrudModule in YourApplication.php for this command to be available.

# ViewBridges

> ViewBridges are Javascript files that interact with a Leaf and it's subleaves. 
> They allow us to attach events to subleaves that be handled and also call events back on our Leaf on the Server. 

Let's be fancy, on our Edit Post page, how about we save the Title whenever the user has finished typing. The save button will still send the title but we want to have to do that.

In your `Posts` directory, add a new file called `PostsItemViewbridge.js`. In this file, we need to create our viewbridge.

```js
ViewBridge.create(
    "PostsItemViewbridge",
    function () {
        return {
            attachEvents: function () {
                // TODO: Attach events.
            }
        }
    }
);
```

What this does is: 
* Create the Viewbridge for the page
* Give it a name (PostsItemViewbridge)
* Define a function called `attachEvents` that will be called when the page has loaded. This is where we can put the events that we mentioned earlier. 

## Client Side Event Handlers

The first thing that we need to do is find the Viewbridge of the subleaf that we created called "Title". I.e. the Title text box.

In attachEvents, add the extra code below between `// Added:` and `// end of added`.

```js
ViewBridge.create(
    "PostsItemViewbridge",
    function () {
        return {
            attachEvents: function () {
                // Added:
                // The Subleaf (TextBox) Title that we created in our PostsItemView
                var title = this.findChildViewBridge("Title");
                // Run this method when The value of Title changes 
                title.attachClientEventHandler("ValueChanged",
                function (element, value) {
                    // Alert to the user that the title is what was just typed
                    alert("The title is: " + value);
                }
            );
            // bind() ensures that the variable called "this" still references our ViewBridge in this method
            }.bind(this)
            // end of added
        }
    }
);
```
## Registering a ViewBridge for a Leaf

Now, we need to tell the `PostItemView` that it should deploy and use `PostItemViewbridge`. 

> We use `LeafDeploymentPackage` to take our Viewbridge JavaScript file and move it to a folder in `deployed/` and also to add the reference to the file in <head>.

In `PostItemView` override `getViewBridgeName()` and `getDeploymentPackage()`. 

```

protected function getViewBridgeName()
{
    // The name of the ViewBridge defined in PostsItemViewbridge.js
    return "PostsItemViewbridge";
}

public function getDeploymentPackage()
{
    // The path to the ViewBridge file.
    return new LeafDeploymentPackage(__DIR__ . "/PostsItemViewbridge.js");
}
```

Go to [http://localhost:8080/posts/1/](http://localhost:8080/posts/1/), change the title and cilck out of the box and you should see an alert with the title.

## Server Events
    
> A server event (AKA ajax call / XMLHttpRequest) is simply a way to run a method on the Leaf back on the server triggered by an event on the web page, 
> for example, our ValueChanged event. 

Update your ViewBridge with the code between the `// Added:` and `// End of Added.` comments. Read the annotations to see what's happening. 

```js
ViewBridge.create(
  "PostsItemViewbridge",
  function () {
    return {
      attachEvents: function () {
        // The Subleaf (TextBox) Title that we created in our PostsItemView
        var title = this.findChildViewBridge("Title");
        // Run this method when The value of Title changes
        title.attachClientEventHandler("ValueChanged",
          function (element, value) {
            
            // Added:
            // Usually you display a spinner at this point to let the user know something is happening / loading
            this.raiseServerEvent(
              "TitleChanged", // Name of the event (minus 'Event' at the end)
              value, // The new title
              // Function to run if we are successful
              function (messageBackFromTheServer) {
                alert(messageBackFromTheServer);
                // Usually you would hide the spinner in this function.
              },
              // Function to run if we are not successful
              function () {
                alert("Something went wrong")
                // Ususally you would hide the spinner and display an error message
              }
            );
            // End of Added.
            
            // bind() ensures that the variable called "this" still references our ViewBridge in this method
          }.bind(this)
        );
      }
    }
  }
);
```

In `PostItem`, we now need to define a custom LeafModel to use. In the `Posts` directory, create a new PHP class called `PostsItemModel` which 
extends `CrudModel`.

In the constructor we are going to instantiate our event, the event will be referenced as a public field on the model. See below:

```php
class PostsItemModel extends \Rhubarb\Leaf\Crud\Leaves\CrudModel
{
    // Notice that the event name ends with the word "Event" but the viewbridge should not state this.
    public $TitleChangedEvent;

    public function __construct()
    {
        parent::__construct();
        $this->TitleChangedEvent = new \Rhubarb\Crown\Events\Event();
    }
}
```
In `PostItem`, override `createModel()` and return a new Instance of `PostsItemModel`. Now override `onModelCreated()` and add the following: 

```php
    protected function createModel()
    {
        return new PostsItemModel();
    }
    
    /**
     * Add this to improve auto complete
     * @var $model PostsItemModel
     */
    protected $model;

    protected function onModelCreated()
    {
        // This is important to make sure the existing events, for example the savePressedEvent still runs
        parent::onModelCreated();
        // Here we attach a handler to our event, and give it the function to run if it is raised.
        // This type of function is known as a callback or an anonymous function
        $this->model->TitleChangedEvent->attachHandler(

            function ($newTitle) {
                // $newTitle comes from our ViewBridge, where we passed "value" after the name of the event in the ViewBridge
                /** @var \Your\WebApp\Models\Post $post */
                $post = $this->model->restModel;

                // We don't want to save the title if the Post has not been saved before
                if ($post->isNewRecord() == false) {
                    $post->Title = $newTitle;
                    $post->save();
                    $messageBackFromTheServer = "Title updated";
                } else {
                    $messageBackFromTheServer = "I'm a new title, I'm not saved yet.";
                }
                
                return $messageBackFromTheServer;
            }

        );
    }
```
 
Now when the title changes and you refresh the page, the title will stay the same without needing to press save.
