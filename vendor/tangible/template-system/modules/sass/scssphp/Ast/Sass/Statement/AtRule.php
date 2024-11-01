<?php

/**
 * SCSSPHP
 *
 * @copyright 2012-2020 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace Tangible\ScssPhp\Ast\Sass\Statement;

use Tangible\ScssPhp\Ast\Sass\Interpolation;
use Tangible\ScssPhp\Ast\Sass\Statement;
use Tangible\ScssPhp\SourceSpan\FileSpan;
use Tangible\ScssPhp\Visitor\StatementVisitor;

/**
 * An unknown at-rule.
 *
 * @extends ParentStatement<Statement[]|null>
 *
 * @internal
 */
final class AtRule extends ParentStatement
{
    /**
     * @var Interpolation
     * @readonly
     */
    private $name;

    /**
     * @var Interpolation|null
     * @readonly
     */
    private $value;

    /**
     * @var FileSpan
     * @readonly
     */
    private $span;

    /**
     * @param Statement[]|null $children
     */
    public function __construct(Interpolation $name, FileSpan $span, ?Interpolation $value = null, ?array $children = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->span = $span;
        parent::__construct($children);
    }

    public function getName(): Interpolation
    {
        return $this->name;
    }

    public function getValue(): ?Interpolation
    {
        return $this->value;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitAtRule($this);
    }

    public function __toString(): string
    {
        $buffer = '@' . $this->name;
        if ($this->value !== null) {
            $buffer .= ' ' . $this->value;
        }

        $children = $this->getChildren();

        if ($children === null) {
            return $buffer . ';';
        }

        return $buffer . '{' . implode(' ', $children) . '}';
    }
}
