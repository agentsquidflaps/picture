# Lazyloading

If you enable lazyloading, it assumes you have installed the npm package `lazysizes`. 
To install just `npm i lazysizes`. More information can be found about lazysizes [here](https://www.npmjs.com/package/lazysizes).

Once installed and lazysizes has been added to a page, it'll just work, no extra configuration needed.

## Preload SVGs

The Picture class will create a preload SVG images, to avoid layout shifting
as much as possible, for lazy loaded imagery. If an image has a width and height, it'll use these to set
the size, when a width or a height doesn't exist it'll set the size to 100%. If this does not suit your needs,
you can take advantage of the fact that the CSS class `lazyload` is added to an element before the JS can load these in and
`lazyloaded` is added after they've been loaded in.

The default colour of the SVG is `#000000` and the alpha is set to `0.1`. These can be amended simply by...

    source()
        ->setFill('#FF0000')
        ->setFillAlpha('0.5')