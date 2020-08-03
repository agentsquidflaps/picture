# Retina

For adapters that support resizing, just calling `setRetina(true)`
will create a source with retina images, up to x2 support.
If the browser does not support retina, it will gracefully downgrade to a
non-retina version.