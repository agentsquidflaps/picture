# Getting started

## Install
    
    composer install agentsquidflaps/picture

## Requirements

* PHP 7.0 or greater
* GD
* Symfony HTTP foundation 2 or greater
* Intervention image 2.5.1 or greater

### Documentation

Please see below for basic usage or you can go to [https://agentsquidflaps.github.io/picture/#/](https://agentsquidflaps.github.io/picture/#/) for more information.

## Usage

Basic usage...

    new Picture([
        (new PicSum())->setSize(200, 200)
    ])->setDescription('Your resized image')
    
...this will produce the output...

    <picture>
        <source srcset="https://picsum.photos/200/200?random 1x, https://picsum.photos/400/400?random 2x">
        <img src="https://picsum.photos/200/200?random" alt="Your resized image">
    </picture>
    
So what's this doing? 

It's created a standard version and retina version, with a fallback `img` element for browsers that don't support the `picture` element.

### Want some more?
    
How about WebP, retina and lazyloaded images! Just do the following (or similar
with adapters that allow WebP/retina/lazy loading)...

    (new Agentsquidflaps\Picture\Picture([
    	(new Agentsquidflaps\Picture\Adapter\Intervention())->setSize(200, 200)
    ]))
    ->setPath('test.jpg')
    ->setDescription('Your resized image')
    ->setRetina(true)
    ->setWebp(true)
    ->setLazyLoaded(true)
    
...which will produce the following...

    <picture>
        <source srcset="data:image/svg+xml, --placeholder svg for lazy loaded images--"
                data-srcset="/thumbnails/f924053728ca5c6cb1a65902ccc2953f.webp 1x, /thumbnails/23430d514c3a226c3a514db1cadf681b.webp 2x"
                type="image/webp">
        <source srcset="data:image/svg+xml, --placeholder svg for lazy loaded images--"
                data-srcset="/thumbnails/9e7411e3ee6341902aece38a530bfada.jpg 1x, /thumbnails/7a03f89e60377bd0b4696f8563adf14e.jpg 2x"
                type="image/jpeg">
        <img src="data:image/svg+xml, --placeholder svg for lazy loaded images--"
             data-src="/thumbnails/9e7411e3ee6341902aece38a530bfada.jpg" class="lazyload" alt="Your resized image">
    </picture>
    
### Some caveats to the above

#### Set your env variables

Firstly, any local source adapters i.e any that get files from a single server,
like Intervention, need to know the path for your images. Both the absolute path to your
web facing folder and the relative path from your web facing path, to the place you'd like your
cached images to sit.

The variables you need to set are...

- `PICTURE_WEB_ROOT`
- `PICTURE_CACHE_RELATIVE_PATH`

...and should be placed in your `.env` file, like so...

    PICTURE_WEB_ROOT=/var/www/html/public
    PICTURE_CACHE_RELATIVE_PATH=/thumbnails
    
#### GD Library

Although, WebP does work on GD library on versions lower than 2.3
(assuming WebP is enabled), it can produce odd results. So it's recommended
you use 2.3 or above for best results. GD library 2.3 is available
from Ubuntu 18 and up. 

#### Lazyloading

Please see [lazyloading](lazyloading.md) for more information.

### Abstractions

It is highly recommended that you use some sort of abstraction layer. For example with Laravel you might...

    $app->bind(Source::class, function() {
        return new Intervention();
    })
    
...this way you can change images across the board or add defaults, like so...

    $app->bind(Source::class, function() {
        return (new Intervention())->setFormat('webp');
    })
    
...then use it as follows...

    new Picture([
        $app->make(Source::class)->setSize(200, 200)
    ])->setDescription('Your resized image') 

### Laravel functions

For those that are using Laravel packages, that is anyone that can
call the `app()` function globally, there are helper methods to ease with the above.
They are `picture()`, `source()` and `mediaQuery()`. Which can be used as follows...

    picture([
        source()->setPath('path to image')->setMediaQuery(mediaQuery()->setMinWidth('sm'))
    ])->setDescription('img description')