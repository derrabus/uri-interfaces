<?php

/**
 * League.Uri (https://uri.thephpleague.com)
 *
 * (c) Ignace Nyamagana Butera <nyamsprod@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace League\Uri\Exceptions;

use League\Uri\IdnaInfo;

final class IdnaConversionFailed extends SyntaxError
{
    /** @var IdnaInfo|null  */
    private $idnaInfo;

    private function __construct(string $message, IdnaInfo $idnaInfo = null)
    {
        parent::__construct($message);
        $this->idnaInfo = $idnaInfo;
    }

    public static function dueToIDNAError(string $domain, IdnaInfo $idnaInfo): self
    {
        return new self(sprintf(
            'The host `%s` is invalid : %s .',
            $domain,
            implode(', ', $idnaInfo->errorList())
        ), $idnaInfo);
    }

    public static function dueToInvalidHost(string $domain): self
    {
        return new self(sprintf('Host `%s` is not a valid IDN host', $domain));
    }

    public function idnaInfo(): ?IdnaInfo
    {
        return $this->idnaInfo;
    }
}
