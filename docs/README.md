# Getting started

## Install
    
    composer install agentsquidflaps/picture
    
## Requirements

* PHP 7.0 or greater
* GD
* Symfony HTTP foundation 2 or greater
* Intervention image 2.5.1 or greater

## Usage

Basic usage...

    new Picture([
        (new PicSum())->setSize(200, 200)
    ])->setDescription('Your resized image')
    
    
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
They are `picture()` and `source()`. Which can be used as follows...

    picture([
        source()->setPath('path to image')
    ])->setDescription('img description')