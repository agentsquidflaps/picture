## Name:

Picture - A PHP class for creating picture elements in a flexible way

## Author:

Tim Norris

## Requirements:

* PHP 7.1 or greater
* GD
* Imagick
* Symfony HTTP foundation 2 or greater
* Intervention image 2.5.1 or greater

## Install:
    
    composer install agentsquidflaps/picture

## Usage

Basic usage...

    new Picture([
        (new PicSum())->setSize(200, 200)
    ])->setDescription('Your resized image')
    
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

## Adapters

Adapters are used to add flexibility. Depending on the location of your images. Dev specific adapters include...

- PicSum
- PlaceImg
- NullImg (used for testing) 

For images found locally, (i.e. on a server) there's the Intervention adapter. There's also a Cloudfront adapter, but given
the highly flexible nature of Cloudfront / S3 / Lambda image manipulators, this should just be used as an example.

### Create your own adapter

Create your own adapter by just extending `Source` and adding a `get` method to it.

For example...

    class TestSource extends Source
    {
    	/**
    	 * @return string
    	 */
        public function get(): string
        {
            // Do something with the path
            return $this->getPath();
        }
    }

### Lazyloading

If you enable lazyloading, it assumes you have installed the npm package `lazysizes`. 
To install just `npm i lazysizes`. More information can be found about lazysizes [here](https://www.npmjs.com/package/lazysizes).