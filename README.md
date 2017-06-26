# Form Generator Sprinkle Example
This Sprinkle provides a summary example on how to use the [FormGenerator](https://github.com/lcharette/UF_FormGenerator) sprinkle.

## Install
Edit UserFrosting `app/sprinkles.json` file and add the following to the `require` list : `"lcharette/UF_FormGeneratorExample": "~2.0.0"`. Also add `FormGenerator` and `FormGeneratorExample` to the `base` list. For example:

```
{
    "require": {
        "lcharette/uf_userprofile": "~2.0.0"
    },
    "base": [
        "core",
        "account",
        "admin",
        "FormGenerator",
        "FormGeneratorExample"
    ]
}
```

Run `composer update` then `composer run-script bake` to install the sprinkle.

### Try it !
Navigate to `http://YourDomain.com/projects`.

This demo is not linked to any database tables, so changes are not actually saved ;)

![Screenshot 1](/screenshots/UF_FormGeneratorExample1.png?raw=true)
![Screenshot 1](/screenshots/UF_FormGeneratorExample2.png?raw=true)
![Screenshot 1](/screenshots/UF_FormGeneratorExample3.png?raw=true)
![Screenshot 1](/screenshots/UF_FormGeneratorExample4.png?raw=true)
