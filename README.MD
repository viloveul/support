
# Installation

make sure your php version > 7.0

```bash
composer require viloveul/support
```

## Helpers
- array_get($arrays, 'outer-key.sublevel-key.subsublevel-key.etc', 'default is null');
- array_has($arrays, 'outer-key.sublevel-key.subsublevel-key.etc');
- array_only($arrays, ['index-one', 'index-four', 'index-five']);

- dd($someVariable, $otherVariable, $anotherVariable);
- env('YOUR_KEY', 'default is null');
- str_contains($str, $needle, $sensitive = true)