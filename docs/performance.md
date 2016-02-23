Some notes on performance
=========================

Frameworks like Rhubarb help us develop better code. Tools like ORM, MVC, MVP and URL routing teach
us about abstraction, dependency inversion, separation of concerns and many other principles (if you
haven't read about the [SOLID principles](https://en.wikipedia.org/wiki/SOLID_%28object-oriented_design%29)
to class design, you should). They show us modern patterns that help us follow those principles. However
if that comes with an expensive performance price tag, the promise of frameworks become diluted.

Performance rides shotgun with best practice design.

Applications start small but over time their complexity grows. What started as a 15 model ORM schema
can over the years develop into a 300 model monster. The code is clean, all 300 models are required
by the application; it is simply a complex application and we've only considered the model. The URL
routing for such a system could require hundreds, if not thousands of routes.

Will even simple requests suffer due to the overhead of initialising the application?

A key goal of Rhubarb is to build a framework that doesn't suffer from the degrading effect of
application growth. Here's some of the ways we've tried to do that:

* Rhubarb supports autoloading (via composer) but tries to avoid using it internally by
requiring dependant classes directly using 'require'.
* Rhubarb rejects string or regular expression based routing in favour of a simple tree of URL handling
objects. Most commonly handled URLs can be moved higher up the tree to maximise performance.
* Rhubarb keeps the complexity of framework features low reducing overall code paths to the bare minimum.
* Rhubarb's logging system allows for the generation of context data to be deferred using call backs
until a logger actually commits to logging the message.
* All configuration uses PHP rather than XML, json, YML or ini files, including class mapping
for dependency injection.
* Configurations requiring registration of classes use class names rather than instantiating
objects unnecessarily.
* Relationship mapping in the Stem ORM modelling framework uses a flat array syntax to ensure
related models are lazy loaded if and when the relationship is used.

These measures ensure that application 'boot' time is barely affected by application growth.