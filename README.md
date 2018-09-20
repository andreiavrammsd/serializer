# PHP Serializer

### Under development

Very basic serializer/unserializer.

## Usage
```
$input = '{...}';
$class = ObjectClass::class;

$serializer = SerializerBuilder::instance()
    ->setFormat('json')
    ->build();
    
$object = $serializer->unserialize($input, $class);
```

See [tests](./tests/SerializerTest.php).

## Development

* Requirements: Docker, Make
* Build dev container: make build
* Test/QA: make, make test, make qa
* Work inside container: make run
