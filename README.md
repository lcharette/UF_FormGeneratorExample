# Form Generator Sprinkle Example

[![Donate][kofi-badge]][kofi]
[![Latest Version][releases-badge]][releases]
[![UserFrosting Version][uf-version]][uf]
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Build][build-badge]][build]
[![Codecov][codecov-badge]][codecov]
[![StyleCI][styleci-badge]][styleci]

[kofi]: https://ko-fi.com/A7052ICP
[kofi-badge]: https://img.shields.io/badge/Donate-Buy%20Me%20a%20Coffee-blue.svg
[releases]: https://github.com/lcharette/UF_FormGeneratorExample/releases
[releases-badge]: https://img.shields.io/github/release/lcharette/UF_FormGeneratorExample.svg
[uf-version]: https://img.shields.io/badge/UserFrosting->=%204.3-brightgreen.svg
[uf]: https://github.com/userfrosting/UserFrosting
[build]: https://github.com/lcharette/UF_FormGeneratorExample/actions?query=workflow%3ABuild
[build-badge]: https://github.com/lcharette/UF_FormGeneratorExample/workflows/Build/badge.svg?branch=master
[codecov]: https://codecov.io/gh/lcharette/UF_FormGeneratorExample
[codecov-badge]: https://codecov.io/gh/lcharette/UF_FormGeneratorExample/branch/master/graph/badge.svg
[styleci]: https://styleci.io/repos/80257783
[styleci-badge]: https://styleci.io/repos/80257783/shield?branch=master&style=flat

This Sprinkle provides a summary example on how to use the [FormGenerator](https://github.com/lcharette/UF_FormGenerator) sprinkle for [UserFrosting 4](https://www.userfrosting.com).

# Help and Contributing

If you need help using this sprinkle or found any bug, feels free to open an issue or submit a pull request. You can also find me on the [UserFrosting Chat](https://chat.userfrosting.com/) most of the time for direct support.

# Installation
Edit UserFrosting `app/sprinkles.json` file and add the following to the `require` list : `"lcharette/uf_formgeneratorexample": "^4.0.0"`. Also add `FormGenerator` and `FormGeneratorExample` to the `base` list. For example:

```json
{
    "require": {
        "lcharette/uf_formgeneratorexample": "^4.0.0"
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

![Screenshot 1](/.github/screenshots/UF_FormGeneratorExample1.png?raw=true)
![Screenshot 2](/.github/screenshots/UF_FormGeneratorExample2.png?raw=true)
![Screenshot 3](/.github/screenshots/UF_FormGeneratorExample3.png?raw=true)
![Screenshot 4](/.github/screenshots/UF_FormGeneratorExample4.png?raw=true)

# Licence

By [Louis Charette](https://bbqsoftwares.com). Copyright (c) 2020, free to use in personal and commercial software as per the MIT license.
