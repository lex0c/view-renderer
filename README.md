## View Renderer

This is a renderer for rendering in view into a PSR-7 Response object.

```php
//Construct the View
$view = new Renderer("./path/to/templates");

//Render a Template
$response = $view->render(new Response(), "template.php", $data);
```

## Template Variables

Add variables to provide data that has been available for all templates.

```php
//Via constructor
$view = new Renderer("./path/to/templates",  [
    "title" => "Hello World"
]);

//and,or setter
$view->setAttributes( [
    "content" => "Welcome"
]);
```

## Exceptions
`RuntimeException` - if template does not exist
