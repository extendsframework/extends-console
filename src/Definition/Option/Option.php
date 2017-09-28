<?php
declare(strict_types=1);

namespace ExtendsFramework\Console\Definition\Option;

use ExtendsFramework\Console\Definition\Option\Exception\NoShortAndLongName;

class Option implements OptionInterface
{
    /**
     * Option name.
     *
     * @var string
     */
    protected $name;

    /**
     * Short name.
     *
     * @var null|string
     */
    protected $short;

    /**
     * Long name.
     *
     * @var null|string
     */
    protected $long;

    /**
     * If a argument is allowed.
     *
     * @var bool
     */
    protected $isFlag;

    /**
     * If multiple arguments are allowed.
     *
     * @var bool
     */
    protected $isMultiple;

    /**
     * If this option is required.
     *
     * @var bool
     */
    protected $isRequired;

    /**
     * Create new option.
     *
     * @param string      $name
     * @param null|string $short
     * @param null|string $long
     * @param bool        $isFlag
     * @param bool        $isMultiple
     * @param bool        $isRequired
     * @throws OptionException
     */
    public function __construct(string $name, string $short = null, string $long = null, bool $isFlag, bool $isMultiple, bool $isRequired)
    {
        if ($short === null && $long === null) {
            throw new NoShortAndLongName($name);
        }

        $this->name = $name;
        $this->short = $short;
        $this->long = $long;
        $this->isFlag = $isFlag;
        $this->isRequired = $isRequired;
        $this->isMultiple = $isMultiple;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getShort(): ?string
    {
        return $this->short;
    }

    /**
     * @inheritDoc
     */
    public function getLong(): ?string
    {
        return $this->long;
    }

    /**
     * @inheritDoc
     */
    public function isFlag(): bool
    {
        return $this->isFlag;
    }

    /**
     * @inheritDoc
     */
    public function isMultiple(): bool
    {
        return $this->isMultiple;
    }

    /**
     * @inheritDoc
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }
}
