The Manual
==========

> The Rhubarb documentation is constantly being updated as the code is continually improved. Should you find any
> issues with the documentation from misspellings to demo code that no longer works, please
> [report it](mailto:rhubarbphp@googlegroups.com) or [fix it](/contributing)

## Introduction

Each chapter of the Rhubarb manual walks you through a module of Rhubarb starting from simple concepts and
building to the advanced topics and features. Finally some chapters end with a look at strategies for
handling common scenarios.

## Table of Contents

### 1. [Rhubarb Essentials](/manual/rhubarb/)

Looks at the essential concepts underpinning the Rhubarb framework and the classes that form them. We'll
explore Modules, Layouts, UrlHandlers, Request and Response, exception handling, Date Time, Emailing, Record Streams,
Encryption, Settings, Sessions and more.

### 2. [Modelling with Stem](/manual/module-stem/)

Abstract your database layer with the Rhubarb ORM tool 'Stem'. Create model objects, collections and relationships
all abstracted from the real data provider through repositories, filters and aggregates.

### 3. [Rapid user interface building with Leaf](/manual/module-leaf/)

'Leaf' is a hierarchical model-view-presenter framework allowing you to rapidly build complex user interfaces
through much smaller and simpler units which all follow the model-view-presenter pattern. Fast, testable, and
tidy - you will be surprised how much you can build so quickly.

### 4. [Building REST APIs](/manual/module-restapi/)

Whether creating bespoke resources objects or exposing model objects from 'Stem', our restapi module will help
you build secure APIs that conform to the very best API standards.

### 5. [Scaffolds](/manual/scaffolds/)

Scaffolds let you import whole units of functionality to your application. They work out-of-the-box but are
often configurable, and if you can't configure them to your liking you can exploit Rhubarb's modular nature and
simply replace or amend the parts you don't like.