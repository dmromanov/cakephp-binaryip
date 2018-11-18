<?php

namespace BinaryIp\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type;
use Cake\Database\TypeInterface;
use Cake\Log\LogTrait;
use Cake\Validation\Validation;
use InvalidArgumentException;
use Psr\Log\LogLevel;
use function inet_ntop;
use function inet_pton;
use function is_string;

class BinaryIpType extends Type implements TypeInterface
{
    use LogTrait;

    /**
     * {@inheritDoc}
     */
    public function toPHP($value, Driver $d)
    {
        if (!$value) {
            return null;
        }

        $ip = @inet_ntop($value);

        if (!$ip) {
            $this->log(__d('di', 'Could not unpack IP address.'), LogLevel::WARNING);
        }

        return $ip;
    }

    /**
     * {@inheritDoc}
     */
    public function toDatabase($address, Driver $driver)
    {
        if (!is_string($address) || !$address) {
            throw new InvalidArgumentException(__d('bi', 'IP must be a non-empty string.'));
        }

        if (!Validation::ip($address)) {
            throw new InvalidArgumentException(__d('bi', 'Provided value must be a valid address'));
        }

        return inet_pton($address);
    }
}
