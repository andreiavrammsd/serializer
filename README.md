# PHP Serializer

Very basic serializer/unserializer (currently only unserialize feature is implemented).
Also transforms data by types and/or callbacks.

## Usage
```
$input = '{...}';
$class = ObjectClass::class;

$serializer = SerializerBuilder::instance()
    ->setFormat('json')
    ->build();
    
$object = $serializer->unserialize($input, $class);

print_r($object->toArray());
```

See [tests](./tests/SerializerTest.php).

## Property annotations (all annotations are optional)
* Property: name of key in input. If not set, the variable name is used.
* Type: If set, the value will be transformed as follows
    * int, float, string, bool, array: will cast value to the [type](https://secure.php.net/manual/en/language.types.intro.php#language.types.intro).
    * collection: value will be wrapped by a [countable iterator with array access](./src/Collection.php).
    * [DateTime](https://secure.php.net/manual/en/book.datetime.php): creates a DateTime object, formatting the value by [formats](https://secure.php.net/manual/en/datetime.createfromformat.php#refsect1-datetime.createfromformat-parameters) given as arguments; first valid format is used.
    * Fully qualified class name: the value will be parsed into the given class.
    * Array of class: the value will be parsed into an array with each element parsed into the given class.
    * Collection of class: the value will be parsed into a [collection](./src/Collection.php) with each element parsed into the given class.
* Callback: A callable (function or class method) is accepted (with optional parameters). The value will be passed to the callable (with the optional parameters, if set), and the new value will be the result of the callable.

#### Examples
* @Serializer\Property("first_name")

* @Serializer\Type("int")
* @Serializer\Type("float")
* @Serializer\Type("string")
* @Serializer\Type("bool")
* @Serializer\Type("array")
* @Serializer\Type("collection")
* @Serializer\Type("DateTime","Y-m-d H:i", "Y-m-d")
* @Serializer\Type("Entity\User")
* @Serializer\Type("array[Entity\User]")
* @Serializer\Type("collection[Entity\User]")

* @Serializer\Callback("strtoupper")
* @Serializer\Callback("substr", "0", "3")
* @Serializer\Callback("[User\NameFormatter, firstName]")
* @Serializer\Callback("[User\NameFormatter, lastName]", "1", "3")

## Object class annotations
* Collection: a class annotated with Collection and extending the [Collection](./src/Collection.php) class will be a collection class with its items of the specified class type.

#### Examples
* @Serializer\Collection("Entity\User")

## ToArray
You can get the array representation of a class by using [ToArrayTrait](./src/ToArray/ToArrayTrait.php). It's recommended you indicate your class can return the array representation by [ToArrayInterface](./src/ToArray/ToArrayInterface.php).
All your classes you need an array value from must implement ToArrayInterface. Nulls items are not set in arrays, arrays with no elements are nulls.

## Development
* Requirements: Docker, Make
* Install dev container: make install
* Run QA tools: make
* Work inside dev container: make run, ./dev/qa.sh
* Remove docker image: make clean
