Simple Template Engine
=======================
Simple template engine written in PHP.

## Demo
Simple example of use:
```php
$te = new TemplateEngine(
    '<strong>{{user.name}} <u>{{user.age}}</u></strong>: Lorem ipsum dolor {{name}} amet. {{not-existing}} and empty {{}}. '
);

$te->addParameter('name', 'New York');
$te->addParameters(Array('name' => 'John Doe', 'age' => '54'), 'user.');

echo $te->render();
```
and result: 
```html
<strong>John Doe <u>54</u></strong>: Lorem ipsum dolor New York amet. {{not-existing}} and empty {{}}.
```
