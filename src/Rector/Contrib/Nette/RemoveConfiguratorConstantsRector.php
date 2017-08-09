<?php declare(strict_types=1);

namespace Rector\Rector\Contrib\Nette;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Scalar\String_;
use Rector\Deprecation\SetNames;
use Rector\Rector\AbstractRector;

final class RemoveConfiguratorConstantsRector extends AbstractRector
{
    public function isCandidate(Node $node): bool
    {
        if ($node instanceof ClassConstFetch) {
            // @todo: check FQN namespace
            $className = (string) $node->class;
            if (! in_array($className, ['Nette\Configurator', 'Configurator'], true)) {
                return false;
            }

            if (! in_array((string) $node->name, ['DEVELOPMENT', 'PRODUCTION'], true)) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param ClassConstFetch $classConstFetchNode
     */
    public function refactor(ClassConstFetch $classConstFetchNode): ?Node
    {
        $constantName = (string) $classConstFetchNode->name;
        $string = strtolower($constantName);

        return new String_($string);
    }

    public function getSetName(): string
    {
        return SetNames::NETTE;
    }

    public function sinceVersion(): float
    {
        return 2.3;
    }
}
