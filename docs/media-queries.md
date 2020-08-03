# Media Queries

Media queries can be set on a source element, by either manually adding `media`
to the list of attributes and calling `setAttributes` on a source or by using the `MediaQuery` class
and passing a class to the `setMediaQuery` method.

## Media Query class

`MediaQuery` can ease the hassle of adding media queries manually, as follows...

    $mediaQuery = (new MediaQuery())->setMinWidth('me')->setMaxWidth('lg')

    new Picture([
        (new Intervention())->setMediaQuery($mediaQuery),   
        (new Intervention())   
    ])
    
By default, screen size widths are based of Bootstrap CSS breakpoints. However
these can be overwritten with custom sizes, by doing the following...

    $mediaQuery = new MediaQuery([
        'my-size' => 500,
        'my-bigger-size' => 750
    ])
    
...then making use of those by...

    $mediaQuery->setMinWidth('my-size')->setMaxWidth('my-bigger-size')
    
...meaning that any source that makes use of the above media query will only show
on screen sizes between 500 and 749px wide.
