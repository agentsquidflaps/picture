# Sources

## Examples

### Production

- [Intervention](/sources/intervention.md)
- [Cloudfront](/sources/cloudfront.md)

### Development

- [Picsum](/sources/picsum.md)
- [PlaceImg](/sources/place-img.md)
- [NullImg](/sources/null-img.md)

## Some notes on sources

Sources are what power the flexibility of Picture. You can make 
adapters yourself and, if you do, please consider adding a pull request to
get it added to the core, so that others can make use of it.

Please note, that Picture doesn't care whether or not a source, makes use of all the
functionality that can be utilised on a source. It just makes a request to get an optimised image.
So there are times where some of the methods will not be applicable to some sources.
It shouldn't error out, but it might not do anything.

For example, calling `getPosition()` might work on the Intervention source, but on other sources, it may not.

### Building for abstraction

To build for abstraction, new public methods should not be added to custom sources, as this will mean, when switching to a new source,
the new source will not may not have this method and will therefore error. If you do add new public methods, please be aware you are breaking
the rules of abstraction for the Picture class and will lose some of the flexibility that comes with that.