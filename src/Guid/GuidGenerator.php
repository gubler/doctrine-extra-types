<?php
/**
 * This file is part of the gubler/doctrine-extra-types library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Daryl Gubler <http://dev88.co>
 * @license http://opensource.org/licenses/MIT MIT
 * @link https://packagist.org/packages/gubler/doctrine-extra-types Packagist
 * @link https://github.com/gubler/doctrine-extra-types GitHub
 */

namespace Gubler\DoctrineExtraTypes\Guid;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Ramsey\Uuid\Codec\GuidStringCodec;
use Ramsey\Uuid\UuidFactory;

/**
 * GUID generator for the Doctrine ORM.
 */
class GuidGenerator extends AbstractIdGenerator
{
    /**
     * Generate an identifier
     *
     * @param \Doctrine\ORM\EntityManager  $em
     * @param \Doctrine\ORM\Mapping\Entity $entity
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function generate(EntityManager $em, $entity)
    {
        $factory = new UuidFactory();

        $codec = new GuidStringCodec($factory->getUuidBuilder());

        $factory->setCodec($codec);

        return $factory->uuid4();
    }
}
