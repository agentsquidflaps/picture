# Methods

Most methods can be called on the picture class, to set a default for all source of a Picture element.

For example...

    new Picture([new Intervention(), new Intervention()])->setPath('path to image')

### getVersion()

`Default: 1`

Returns the version of a source. Used primarily for systems where files can have versions or cache busting.

### setVersion(int $version)

Set the version of source

### getPath()

Get the location of source

### setPath(int $path)

Set the location of source

### getWidth()

Get the requested width of source

### setWidth(int $width) 

Set the width of source

### getHeight()

Get the height of source

### setHeight(int $height)

Set the height of source

### setSize(int $width, int $height)

Shorthand for setWidth and setHeight

### getAttributes()

Get the html attributes of a source

### setAttributes(array $attributes)

Set the html attributes of a source. Accepted keys for a html source element is 'media',
 whereas for the img, you're allowed all but 'media'  

For example...

    new Picture((new PicSum)->setAttributes(['class' => 'img-class']))

### getDescription()

Get the alt description of source

### setDescription()

Set the alt description of source

### isLazyLoaded()

`Default: false`

Tells you if a source is intended to be lazy loaded

### setLazyLoaded(bool $lazyLoaded)

Set source to be lazy loaded or not

### isRetina()

`Default: true`

Tells you if a retina source will be created

### setRetina(bool $retina)

Set retina source to be created or not

### isWebp()

`Default: true`

Tells you if a webp source will be created

### setWebp(bool $webp)

Set webp source to be created or not

### getTag()

Tells you if the source will be an img or source html inside of the picture element

### setTag(string $type)

Set what type of element to make. Only 'img' or 'source' are allowed.

### getFill()

Get the colour of the fill to be used on the pre-image when lazy loading is turned on

### setFill(string $hex)

Set the colour of the fill to be used on the pre-image when lazy loading is turned on. Hex colours.

### getFillAlpha()

Get the alpha of the fill to be used on the pre-image when lazy loading is turned on

### setFillAlpha(string | float $alpha)

Set the alpha of the fill to be used on the pre-image when lazy loading is turned on. 0 is invisible and 1 is opaque.

### getFit()

Get the type of fit for an optimised image

### setFit(string $fit)

Set the type of fit for an optimised image. Supported values are currently...

- `cover`

  Preserving aspect ratio, ensure the image covers both provided dimensions by cropping/clipping to fit.
  
- `contain`

  Preserving aspect ratio, contain within both provided dimensions using "letterboxing" where necessary.
  
- `fill`

  Ignore the aspect ratio of the input and stretch to both provided dimensions.
  
- `inside`

  Preserving aspect ratio, resize the image to be as large as possible while ensuring its dimensions are less than or equal to both those specified.
  
- `outside`

  Preserving aspect ratio, resize the image to be as small as possible while ensuring its dimensions are greater than or equal to both those specified.

...largely inspired from the [sharp](https://sharp.pixelplumbing.com/) image library

### getPosition()

Get the position of source

### setPosition(string $position)

Set the position of the source image. As in, which part of the image gets seen. Supported values are...

- 1 (top)
- 2 (right)
- 3 (bottom)
- 4 (left)
- 5 (top right)
- 6 (bottom right)
- 7 (bottom left)
- 8 (top left)

...or strategies...

- 16 (entropy) 
- 17 (attention)

...again, largely inspired from the [sharp](https://sharp.pixelplumbing.com/) image library  

### getFormat()

Get the format of the source

### setFormat(string $format)

Set the format of the source. For example, 'jpg' or 'png'

### getQuality()

`Default: 80`

Get the quality of the source

### setQuality(int $quality)

Set the quality of the source. Value between 1 - 100.

### setOptions(array $options)

Set multiple options at once. Key values are the snake case version of the relevant method, sans the set prefix

For example...

    new Picture((new Intervention())->setOptions([
        'width' => 100,
        'height' => 100,
        'retina' => true
    ]))

### getMediaQuery()

Gets the media query object of a source. Currently only supported on the `Source` class, not `Picture`
  
### setMediaQuery(MediaQuery $mediaQuery)

Sets the media query object of a source. Currently only supported on the `Source` class, not `Picture`

### isSupported()

Determines whether the image manipulator can/should manipulate images. If the 
method returns true, it's supported, otherwise false and then just the original path will be output