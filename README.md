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
* Install dev container: make install
* Run QA tools: make
* Work inside dev container: make run
* Remove docker image: make clean
