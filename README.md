# Statico

[![Build Status](https://travis-ci.org/matthewbdaly/statico.svg?branch=master)](https://travis-ci.org/matthewbdaly/statico)
[![Coverage Status](https://coveralls.io/repos/github/matthewbdaly/statico/badge.svg?branch=master)](https://coveralls.io/github/matthewbdaly/statico?branch=master)

A minimal CMS. Features include:

* Defaults to pulling content from Markdown files, but you can implement your own source to pull it from any source you like, whether that's a database, API or whatever else is appropriate
* Files are fetched using Flysystem, meaning they can be stored locally and kept under version control, or pulled in from an S3 bucket, Dropbox folder or an FTP server
* Uses Twig for templating
* Comes with Laravel Mix and Tailwind configured out of the box
* Easy configuration with Zend Config - you can configure it with YAML, PHP arrays, or any other supported configuration mechanism
* Caching built in, with support for multiple backends
* Support for multiple Monolog loggers
* Search using Fuse.js

Planned features include:

* Differing configuration between environments - so your dev and production environments can use different cache backends, for example
* Dynamic form generation from config
* Multiple notifiers for form submission, including mail, SMS and webhook support, for easy integration into your own systems
* Dynamically generate navigation bars from content
* Support for taxonomies
* Plugin system

# The Statico CLI

Statico comes with its own command-line runner, which you can call like this:

```
$ php statico
```

This will display the available commands.

# Where's the admin?

By design, Statico doesn't include an admin interface out of the box. The intention is to optimise for developer's workflow rather than that of site owners, and so Markdown files are a better way to manage that.

Once the plugin system is in place, it may be possible to use that to add an admin interface, but it's out of scope for the core system.

# How do I set it up?

As it is right now, it's a single web application, and not ready for use.

The plan is that once it's feature complete, I'll divide it into two repositories. `statico/core` will be the code in the `src/` folder, and will contain the application code proper. The rest will form the basis of `statico/template`, which will be an initial boilerplate that pulls in `statico/core` as a dependency. Users wanting to build a new project will run the `composer create-project` command to pull in `statico/template`, and that will give them a basic boilerplate that includes some Twig views, config files, and basic bootstrapping. The aim will be to keep as much as possible in `statico/core` so that as far as possible, updates are merely a matter of running `composer update`.

# What's the intended use case for this?

Basically, the ideal site for using Statico meets the following criteria:

* Is a brochure site
* Is maintained primarily by developers (as opposed to site owners)

In my experience, many of these sites get built with Wordpress, for two reasons:

* Wordpress has substantial mindshare
* Supposedly, the fact it has an admin interface lets clients update it themselves

However, in my experience, Wordpress often turns out to be too complex for many non-technical users to administer, so developers end up being the ones asked to make any changes. They therefore have to cope with an interface that's not optimised for their skill sets.

Add to that the fact that Wordpress, at least out of the box, lacks a proper templating language and front end scaffolding, puts too much in the database, and isn't set up to handle different environments correctly, and you have a recipe for disproportionate amounts of frustration. Also, Wordpress requires a database, can be slow, and is a common target for exploitation.

Instead, Statico enables a workflow more familiar to developers who use modern MVC frameworks like Laravel. You're given a basic boilerplate to get you started, and can create and theme your own layouts, as well as add Javascript. Content can either be stored locally, so it can be version controlled with the rest of the site for easy rollbacks, or pulled in using one of the remote filesystems. This can allow for some more creative workflows, such as pulling content from a Dropbox folder.

If you have a large number of similar sites, Statico may suit your use case. You can easily copy the layout and front end files between installs, and content files can either be copied, or pulled from the same remote source. Similarly, small or relatively simple sites that don't change often may also be a good fit.
