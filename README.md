# Form Generator Sprinkle Example
This Sprinkle provides a summary example on how to use the [FormGenerator](https://github.com/lcharette/UF_FormGenerator) sprinkle.

## Install
`cd` into the sprinkle directory of UserFrosting and clone as submodule:
```
git submodule add git@github.com:lcharette/UF_FormGeneratorExample.git FormGeneratorExample
```

### Add to the sprinkle list
Edit UserFrosting `app/sprinkles/sprinkles.json` file and add `FormGeneratorExample` to the sprinkle list to enable it globally. Don't forget to install [FormGenerator](https://github.com/lcharette/UF_FormGenerator) too, then run `composer update` and `npm run uf-assets-install`.

### Try it !
Navigate to `http://YourDomain.com/projects`.

This demo is not linked to any database tables, so changes are not actually saved ;)
