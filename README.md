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
