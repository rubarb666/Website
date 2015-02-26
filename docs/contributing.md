Contributing
============

Rhubarb is an open source project licensed using the Apache 2.0 License.

Everyone is welcome to get involved and make contributions to the project. Contributions
generally fall into three main areas:

### 1. The 'core' Rhubarb modules: e.g. rhubarb, module-stem, module-leaf, scaffold-authentication

All of the repositories in the [rhubarbphp](https://github.com/rhubarbphp) Github organisation embody the heart
and spirit of the system. Their integrity is guaranteed by a list of
[appointed maintainers](https://github.com/orgs/RhubarbPHP/teams). However we welcome and love contributions
from anyone and contributions should be made using a pull request from a forked version of the module in question
into the 'develop' branch of the original repository.

### 2. Scaffolds

The ability to create scaffolds that deploy working components, and sometimes entire sections, of functionality
through one package with zero configuration is one of the most fun aspects of working in Rhubarb. Everyone is
free to share their own scaffolds with the community by publishing their module in [packagist.org](http://packagist.org)

### 3. Documentation

Documenting a framework like Rhubarb is no easy task. If you find our documentation to be confusing, out of date,
contradictory or just plain boring please consider helping us make it right. Our documentation is stored as
markdown files in the "docs/" folder of each repository.

## How to make modifications to existing modules

> Before you start please be aware **you cannot push to the official repositories**. You must make a fork of the relevant
> module into your personal github account and make a pull request from there.

If you are a programming ninja and can trust your unit tests to guide you to completion then you simply need
to clone your forked repos, make your changes, commit and do a PR to the develop branch in the original repos.

However in most cases you will want to see the effect of your changes in an active project. To do this you need
first to inform composer that it should prefer your version of the module over the official version and secondly
set the version number to the dev- branch you're working on.

``` js,[3,4,5,6,11]
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/acuthbert/module-stem"
        }
    ],
    "require":
    {
        "rhubarbphp/rhubarb": "1.*",
        "rhubarbphp/module-stem": "dev-develop"
    }
}

```

Now do a `composer update` and you're ready to make your changes.

Once your changes are complete you need to commit your changes and then push to origin

``` bash
git commit -am "Refactored the pipeline filtering mechanism"
git push origin
```

You must specifically mention origin in your push command as the default remote (called composer funny enough)
is read only.

## License

Rhubarb and its modules subscribe to the Apache License 2.0. All contributed files should contain the standard
header as found in any existing Rhubarb code file.

## Style Guide

Rhubarb and its modules use the [PSR-1](http://www.php-fig.org/psr/psr-1/) and [PSR-2](http://www.php-fig.org/psr/psr-2/)
coding styles standardised by [php-fig.org](http://www.php-fig.org). All contributions should conform to this
standard.

## Namespaces

* All official Rhubarb projects should start their namespace with Rhubarb.
* All unofficial Rhubarb projects should start their namespace with their appropriate vendor
* All modules should follow the first section of namespace with the module namespace name.

  e.g.

  Rhubarb\Leaf

* All scaffold projects should follow the first section of namespace with "Scaffolds\" and then the module
  namespace name.

  e.g.

  Rhurbarb\Scaffolds\Authentication

## Folders

Rhubarb follows the [PSR-4](http://www.php-fig.org/psr/psr-4/) namespacing and foldering conventions for class files.
Code files should go into a folder called 'src' with further folder dictating the namespace of the class. Namespace
roots should be registered in the project's composer.json file.

Unit tests should go into a 'tests' folder at the same level as the 'src' folder. The sub foldering should mirror
that of the class under test. The namespace root of the 'tests' folder should be the same as the 'src' folder but
with '\Tests' appended to the root.

e.g.
```
Class: src/Models/Model.php
Namespace: Rhubarb\Stem\Models

Test: tests/Models/ModelTest.php
Namespace: Rhubarb\Stem\Tests\Models
```
