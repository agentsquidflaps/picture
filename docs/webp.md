# WebP

For adapters that support the WebP format, just calling `setWebp(true)`
will create a source with WebP images. WebP images are prioritised, due to generally
better compression and will gracefully downgrade, if the browser does not support it