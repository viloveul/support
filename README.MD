
# Installation

make sure your php version > 7.0

```bash
composer require viloveul/support
```

## HOW

```php
require __DIR__ . '/vendor/autoload.php';

// PAGINATION
$pagination = new Viloveul\Support\Pagination('search', $_GET);
$pagination->setBaseUrl('/api/v1/user/index');
$pagination->prepare(function ($pagination, array $conditions = []) {
    $model = new YourUserModelSample();
    foreach ($conditions as $key => $value) {
        $model->where($key, 'LIKE', "%{$value}%");
    }
    // set total results
    $pagination->setTotal($model->count());
    // set result data array
    $pagination->setData(
        $model
            ->orderBy($pagination->getOrderBy(), $pagination->getSortOrder())
            ->skip(($pagination->getCurrentPage() * $pagination->getPageSize()) - $pagination->getPageSize())
            ->take($pagination->getPageSize())
            ->get()
            ->toArray()
    );
});
var_dump($pagination->getResults());
```

## Helpers
- array_get($arrays, 'outer-key.sublevel-key.subsublevel-key.etc', 'default is null');
- array_has($arrays, 'outer-key.sublevel-key.subsublevel-key.etc');
- array_only($arrays, ['index-one', 'index-four', 'index-five']);

- dd($someVariable, $otherVariable, $anotherVariable);
- env('YOUR_KEY', 'default is null');
- str_contains($str, $needle, $sensitive = true)