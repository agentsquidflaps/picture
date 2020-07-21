## Name:

Picture - A PHP class for creating picture elements in a flexible way

## Version:

**0.0.1**

## Author:

Tim Norris

## Requirements:

* PHP 7.2 or greater
* GD
* Imagick
* Symfony HTTP foundation 3 or greater
* Intervention image 2.5.1 or greater

## Install:
    
    composer install agentsquidflaps/picture

## Usage

Basic usage...

    new Picture([
        (new PicSum())->setSize(200, 200)
    ])->setDescription('Your resized image')
    
It is highly recommended that you use some sort of abstraction layer. For example with Laravel you might...

    $app->bind(AbstractSource::class, function() {
        return new Intervention();
    })
    
...this way you can change images across the board or add defaults, like so...

    $app->bind(AbstractSource::class, function() {
        return (new Intervention())->setFormat('webp');
    })
    
## Adapters

Adapters are used to add flexibility. Depending on the location of your images. Dev specific adapters include...

- PicSum
- PlaceImg
- NullImg (used for testing) 

For images found locally, (i.e. on a server) there's the Intervention adapter. There's also a Cloudfront adapter, but given
the highly flexible nature of Cloudfront / S3 / Lambda image manipulators, this should just be used as an example.