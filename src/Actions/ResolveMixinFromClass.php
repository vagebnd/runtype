<?php

namespace Vagebond\Runtype\Actions;

use PhpParser\Node\Name;
use PhpParser\Node\Stmt\UseUse;
use PhpParser\NodeFinder;
use PhpParser\ParserFactory;
use ReflectionClass;
use Vagebond\Runtype\Exceptions\UnresolvableResourceException;

class ResolveMixinFromClass
{
    public function handle(string $class): string
    {
        $classReflection = new ReflectionClass($class);

        return $this->tryResolvingFromDocComment($classReflection);
    }

    private function tryResolvingFromDocComment(ReflectionClass $classReflection): string
    {
        $docComment = $classReflection->getDocComment();

        $mixin = $this->extractMixinFromDocComment($docComment, '/@mixin\s+([\w\\\\]+)/');

        if (empty($mixin)) {
            throw UnresolvableResourceException::noMixinFound($classReflection->getName());
        }

        $resource = head($mixin);

        if (! class_exists($resource)) {
            $resource = $this->tryResolvingFromImports($classReflection, $resource);
        }

        if (! class_exists($resource)) {
            throw UnresolvableResourceException::resourceDoesNotExist($classReflection->getName());
        }

        return $resource;
    }

    private function extractMixinFromDocComment(string $phpdocs, string $pattern): array
    {
        preg_match_all(
            $pattern,
            $phpdocs,
            $mixins
        );

        return array_map(
            function ($mixin) {
                return preg_replace('#^\\\\#', '', $mixin);
            },
            $mixins[1]
        );
    }

    private function tryResolvingFromImports(ReflectionClass $classReflection, $model)
    {
        $parser = (new ParserFactory)->createForNewestSupportedVersion();

        $statements = $parser->parse(file_get_contents($classReflection->getFileName()));

        $nodeFinder = new NodeFinder;

        $useStatements = $nodeFinder->find(
            $statements,
            fn ($node) => $node instanceof UseUse
        );

        $imports = collect($useStatements)
            ->pluck('name')
            ->mapWithKeys(function (Name $name) {
                return [basename(str_replace('\\', '/', $name->name)) => $name->name];
            });

        return $imports->get($model, $model);
    }
}
