<?php declare(strict_types=1);
/*
 * This file is part of PHPLOC.
 *
 * (c) Chris Gmyr <cmgmyr@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Cmgmyr\PHPLOC;

final class Arguments
{
    public function __construct(
        /**
         * @var array<int, string>
         */
        private readonly array $directories,
        /**
         * @var array<int, string>
         */
        private readonly array $suffixes,
        /**
         * @var array<int, string>
         */
        private readonly array $exclude,
        private readonly bool $countTests,
        private readonly ?string $csvLogfile,
        private readonly ?string $jsonLogfile,
        private readonly ?string $xmlLogfile,
        private readonly bool $help,
        private readonly bool $version
    ) {
    }

    /**
     * @return array<int, string>
     */
    public function directories(): array
    {
        return $this->directories;
    }

    /**
     * @return array<int, string>
     */
    public function suffixes(): array
    {
        return $this->suffixes;
    }

    /**
     * @return array<int, string>
     */
    public function exclude(): array
    {
        return $this->exclude;
    }

    public function countTests(): bool
    {
        return $this->countTests;
    }

    public function csvLogfile(): ?string
    {
        return $this->csvLogfile;
    }

    public function jsonLogfile(): ?string
    {
        return $this->jsonLogfile;
    }

    public function xmlLogfile(): ?string
    {
        return $this->xmlLogfile;
    }

    public function help(): bool
    {
        return $this->help;
    }

    public function version(): bool
    {
        return $this->version;
    }
}
