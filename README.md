# DoctrineExtraTypes

This project provides extra or replacement data types for Doctrine 2.

## Installation

The preferred method of installation is via Composer. Run the following command to install the package and add it as a requirement to your project's `composer.json`:

```bash
composer require gubler/doctrine-extra-types
```

## Types

### UTCDateTime

The `UTCDateTimeType` is copied from the [Doctrine ORM documentation][doctine-docs-utc] and converts `DateTime` object's timezone to UTC before storing them in the database.

#### Use

This _replaces_ the existing Doctrine `datetime` type.

In Symfony:
 ``` yaml
# config/packages/doctrine.yaml
doctrine:
    dbal:
        types:
            datetime:
                class: Gubler\DoctrineExtraTypes\UTCDateTime\UTCDateTimeType
```

**Note:** This type _only_ converts the DateTime when saving to the database. This _does not_ convert the datetime back to the original timezone when reading form the database. You will need to convert the UTC datetime to whichever timezone you need.

After this, you can use the `datetime` Doctrine type normally and any DateTimes will be converted to UTC.

### Guid

This project used to supply a GUID doctrine type. This is now provided by [gubler/guid-doctrine](https://github.com/gubler/guid-doctrine)


## Contributing

Contributions are welcome! Please read [CONTRIBUTING][contributing] for details.

This project adheres to a [Contributor Code of Conduct][conduct]. By participating in this project and its community, you are expected to uphold this code.

## Copyright and License

The `gubler/doctrine-extra-types` library is copyright © [Daryl Gubler](http://dev88.co/) and licensed for use under the MIT License (MIT). Please see [LICENSE][license] for more information.

[conduct]: https://github.com/gubler/doctrine-extra-types/blob/master/CODE_OF_CONDUCT.md
[doctrine-field-type]: http://doctrine-dbal.readthedocs.org/en/latest/reference/types.html
[packagist]: https://packagist.org/packages/gubler/doctrine-extra-types
[composer]: http://getcomposer.org/
[contributing]: https://github.com/gubler/doctrine-extra-types/blob/master/CONTRIBUTING.md
[doctrine-getting-started]: http://doctrine-orm.readthedocs.org/en/latest/tutorials/getting-started.html
[doctrine-docs-utc]: https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/cookbook/working-with-datetime.html#handling-different-timezones-with-the-datetime-type
[source]: https://github.com/gubler/doctrine-extra-types
[release]: https://packagist.org/packages/gubler/doctrine-extra-types
[license]: https://github.com/gubler/doctrine-extra-types/blob/master/LICENSE
[build]: https://travis-ci.org/gubler/doctrine-extra-types
[coverage]: https://coveralls.io/r/gubler/doctrine-extra-types?branch=master
[downloads]: https://packagist.org/packages/gubler/doctrine-extra-types
