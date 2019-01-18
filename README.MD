
# Installation

make sure your php version > 7.0

```bash
composer require viloveul/support
```

## AttrAwareTrait

```php

$object = new class implements ArrayAccess {

	use Viloveul\Support\AttrAwareTrait;

	private $attributes = [];	

};

$object->setAttributes(['anu' => 'gemes']);
$object->setFoo('bar');
$object->setAttributes('{"if": "print"}');

var_dump($object->getAnu(), $object->getDor('yes'), $object->getFoo('no'), $object->foo, $object['foo'], $object);

```

## Helpers
- array_get($arrays, 'outer-key.sublevel-key.subsublevel-key.etc', 'default is null');
- array_has($arrays, 'outer-key.sublevel-key.subsublevel-key.etc');
- array_only($arrays, ['index-one', 'index-four', 'index-five']);
- item_to_array(any);

- dd($someVariable, $otherVariable, $anotherVariable);
- env('YOUR_KEY', 'default is null');
- str_contains($str, $needle, $sensitive = true)