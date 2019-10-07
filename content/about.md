---
title: "About Statico"
navigation: true
---

## Who is Statico for?

In contrast to some other content management systems, Statico isn't optimized for end users who want a friendly admin interface. Instead, it's optimized for developers.

The reasons for this decision are as follows:

* Plenty of times, clients ask for sites to be built with something like Wordpress because it has mindshare, or because that's what the developers pushed. However, they then find it too intimidating anyway, and wind up leaving it to the developer to update content. This means you optimize for someone who then doesn't actually use it, leaving the developer stuck with an interface that makes it difficult to use their web development skills. By optimizing for the developer's experience, we're making things easier for the people who often wind up updating the content anyway

## I don't like the default configuration

Fine, change it. The actual work is done by the `statico/core` package, which is pulled in separately with Composer. You can take the existing `statico/template` package, fork it, make the changes you want and use that for your projects. Or you can create a template from scratch. It's up to you - Statico is intended to be flexible.
