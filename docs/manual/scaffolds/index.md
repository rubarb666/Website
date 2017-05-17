Scaffolds and Modules
=====================

In addition to the core modules there are a wide range of additional modules available to
help solve frequently encountered software challenges.

Modules are simply composer packages that contain a library of classes. For example a module
might define a special EmailProvider along with relevant settings classes.

Scaffolds like modules contain a library of classes, but in addition contain some ready to
use behaviours. Simply including the scaffold in your application `getModules()` method
could establish database schemas and/or install user interfaces by registering UrlHandlers.

