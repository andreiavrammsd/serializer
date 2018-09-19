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

* Setup dev container:
    * Build container: make build
    * Run container: make run
    * Install dependencies inside container: composer install

* Run container: make run

* Test/QA (inside container): make, make test, make qa
