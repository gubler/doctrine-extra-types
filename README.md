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

The `GuidType` is based off of [ramsey/uuid-doctrine][ramser-uuid-doctrine] project. The only thing it does differently is use the `GuidStringCodec` for the UUID. This to handle Active Directory GUIDs.

The gubler/doctrine-extra-types package provides the ability to use
[ramsey/uuid][ramsey-uuid] as a [Doctrine field type][doctrine-field-type]. This is a _new_ Doctrine field type.

## Use

### Configuration

To configure Doctrine to use gubler/guid as a field type, you'll need to set up
the following in your bootstrap:

``` php
\Doctrine\DBAL\Types\Type::addType('uuid', 'Gubler\DoctrineExtraTypes\Guid\GuidType');
```

In Symfony:

``` yaml
# config/packages/doctrine.yaml
doctrine:
    dbal:
        types:
            guid:  Gubler\DoctrineExtraTypes\Guid\GuidType
```

### Usage

Then, in your models, you may annotate properties by setting the `@Column`
type to `guid`, and defining a custom generator of `Gubler\DoctrineExtraTypes\Guid\GuidGenerator`.
Doctrine will handle the rest.

``` php
/**
 * @Entity
 * @Table(name="products")
 */
class Product
{
    /**
     * @var \Ramsey\Uuid\Uuid
     *
     * @Id
     * @Column(type="guid", unique=true)
     * @GeneratedValue(strategy="CUSTOM")
     * @CustomIdGenerator(class="Gubler\DoctrineExtraTypes\Guid\GuidGenerator")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
```

If you use the XML Mapping instead of PHP annotations.
``` XML
<id name="id" column="id" type="guid">
    <generator strategy="CUSTOM"/>
    <custom-id-generator class="Gubler\DoctrineExtraTypes\Guid\GuidGenerator"/>
</id>
```

You can also use the YAML Mapping.
``` yaml
id:
    id:
        type: guid
        generator:
            strategy: CUSTOM
        customIdGenerator:
            class: Gubler\DoctrineExtraTypes\Guid\GuidGenerator
```

### Binary Database Columns

In the previous example, Doctrine will create a database column of type `CHAR(36)`,
but you may also use this library to store GUIDs as binary strings. The
`GuidBinaryType` helps accomplish this.

In your bootstrap, place the following:

``` php
\Doctrine\DBAL\Types\Type::addType('guid_binary', 'Gubler\DoctrineExtraTypes\Guid\GuidBinaryType');
$entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('guid_binary', 'binary');
```

In Symfony:
 ``` yaml
# config/packages/doctrine.yaml
doctrine:
    dbal:
        types:
            guid_binary:  Gubler\DoctrineExtraTypes\Guid\GuidBinaryType
        mapping_types:
            guid_binary: binary
```

Then, when annotating model class properties, use `guid_binary` instead of `guid`:

    @Column(type="guid_binary")

### More Information

For more information on getting started with Doctrine, check out the "[Getting
Started with Doctrine][doctrine-getting-started]" tutorial.

## Contributing

Contributions are welcome! Please read [CONTRIBUTING][contributing] for details.

This project adheres to a [Contributor Code of Conduct][conduct]. By participating in this project and its community, you are expected to uphold this code.

## Copyright and License

The gubler/doctrine-extra-types library is copyright © [Daryl Gubler](http://dev88.co/) and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.

[ramsey-uuid-doctrine]: https://github.com/ramsey/uuid-doctrine
[ramsey-uuid]: https://github.com/ramsey/uuid
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
