# Form Generator Sprinkle Example

[![StyleCI](https://github.styleci.io/repos/80257783/shield?branch=master)](https://github.styleci.io/repos/80257783) [![UserFrosting Version](https://img.shields.io/badge/UserFrosting->=%204.3-brightgreen.svg)](https://github.com/userfrosting/UserFrosting) [![Donate](https://img.shields.io/badge/Donate-Buy%20Me%20a%20Coffee-brightgreen.svg)](https://ko-fi.com/A7052ICP)

This Sprinkle provides a summary example on how to use the [FormGenerator](https://github.com/lcharette/UF_FormGenerator) sprinkle for [UserFrosting 4](https://www.userfrosting.com).

# Help and Contributing

If you need help using this sprinkle or found any bug, feels free to open an issue or submit a pull request. You can also find me on the [UserFrosting Chat](https://chat.userfrosting.com/) most of the time for direct support.

# Installation
Edit UserFrosting `app/sprinkles.json` file and add the following to the `require` list : `"lcharette/uf_formgeneratorexample": "^3.0.0"`. Also add `FormGenerator` and `FormGeneratorExample` to the `base` list. For example:

```
{
    "require": {
        "lcharette/uf_formgeneratorexample": "^3.0.0"
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

Run `composer update` then `php bakery bake` to install the sprinkle.

## Try it !
Navigate to `http://YourDomain.com/formgenerator`.

This demo is not linked to any database tables, so changes are not actually saved ;)

![Screenshot 1](/screenshots/UF_FormGeneratorExample1.png?raw=true)
![Screenshot 2](/screenshots/UF_FormGeneratorExample2.png?raw=true)
![Screenshot 3](/screenshots/UF_FormGeneratorExample3.png?raw=true)
![Screenshot 4](/screenshots/UF_FormGeneratorExample4.png?raw=true)

# Licence

By [Louis Charette](https://github.com/lcharette). Copyright (c) 2017, free to use in personal and commercial software as per the MIT license.
