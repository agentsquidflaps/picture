# Adapters

Adapters are used to add flexibility. Depending on the location of your images. Dev specific adapters include...

- PicSum
- PlaceImg
- NullImg (used for testing) 

For images found locally, (i.e. on a server) there's the Intervention adapter. There's also a Cloudfront adapter, but given
the highly flexible nature of Cloudfront / S3 / Lambda image manipulators, this should just be used as an example.

## Create your own adapter

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