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

use function array_intersect;
use function array_sum;
use function count;
use function max;
use function min;

class Publisher
{
    /**
     * @param array<string, mixed> $counts
     */
    public function __construct(private array $counts)
    {
    }

    public function getDirectories(): int
    {
        return $this->getCount('directories') - 1;
    }

    public function getFiles(): int
    {
        return $this->getValue('files');
    }

    public function getLines(): int
    {
        return $this->getValue('lines');
    }

    public function getCommentLines(): int
    {
        return $this->getValue('comment lines');
    }

    public function getNonCommentLines(): int
    {
        return $this->getLines() - $this->getCommentLines();
    }

    public function getLogicalLines(): int
    {
        return $this->getValue('logical lines');
    }

    public function getClassLines(): int
    {
        return $this->getSum('class lines');
    }

    public function getAverageClassLength(): float
    {
        return $this->getAverage('class lines');
    }

    public function getMinimumClassLength(): int
    {
        return $this->getMinimum('class lines');
    }

    public function getMaximumClassLength(): int
    {
        return $this->getMaximum('class lines');
    }

    public function getAverageMethodLength(): float
    {
        return $this->getAverage('method lines');
    }

    public function getMinimumMethodLength(): int
    {
        return $this->getMinimum('method lines');
    }

    public function getMaximumMethodLength(): int
    {
        return $this->getMaximum('method lines');
    }

    public function getAverageMethodsPerClass(): float
    {
        return $this->getAverage('methods per class');
    }

    public function getMinimumMethodsPerClass(): int
    {
        return $this->getMinimum('methods per class');
    }

    public function getMaximumMethodsPerClass(): int
    {
        return $this->getMaximum('methods per class');
    }

    public function getFunctionLines(): int
    {
        return $this->getValue('function lines');
    }

    public function getAverageFunctionLength(): float
    {
        return $this->divide($this->getFunctionLines(), $this->getFunctions());
    }

    public function getNotInClassesOrFunctions(): int
    {
        return $this->getLogicalLines() - $this->getClassLines() - $this->getFunctionLines();
    }

    public function getComplexity(): int
    {
        return $this->getValue('complexity');
    }

    public function getMethodComplexity(): int
    {
        return $this->getValue('total method complexity');
    }

    public function getAverageComplexityPerLogicalLine(): float
    {
        return $this->divide($this->getComplexity(), $this->getLogicalLines());
    }

    public function getAverageComplexityPerClass(): float
    {
        return $this->getAverage('class complexity');
    }

    public function getMinimumClassComplexity(): int
    {
        return $this->getMinimum('class complexity');
    }

    public function getMaximumClassComplexity(): int
    {
        return $this->getMaximum('class complexity');
    }

    public function getAverageComplexityPerMethod(): float
    {
        return $this->getAverage('method complexity');
    }

    public function getMinimumMethodComplexity(): int
    {
        return $this->getMinimum('method complexity');
    }

    public function getMaximumMethodComplexity(): int
    {
        return $this->getMaximum('method complexity');
    }

    public function getGlobalAccesses(): int
    {
        return $this->getGlobalConstantAccesses() + $this->getGlobalVariableAccesses() + $this->getSuperGlobalVariableAccesses();
    }

    public function getGlobalConstantAccesses(): int
    {
        return count(array_intersect($this->getValue('possible constant accesses', []), $this->getValue('constant', [])));
    }

    public function getGlobalVariableAccesses(): int
    {
        return $this->getValue('global variable accesses');
    }

    public function getSuperGlobalVariableAccesses(): int
    {
        return $this->getValue('super global variable accesses');
    }

    public function getAttributeAccesses(): int
    {
        return $this->getNonStaticAttributeAccesses() + $this->getStaticAttributeAccesses();
    }

    public function getNonStaticAttributeAccesses(): int
    {
        return $this->getValue('non-static attribute accesses');
    }

    public function getStaticAttributeAccesses(): int
    {
        return $this->getValue('static attribute accesses');
    }

    public function getMethodCalls(): int
    {
        return $this->getNonStaticMethodCalls() + $this->getStaticMethodCalls();
    }

    public function getNonStaticMethodCalls(): int
    {
        return $this->getValue('non-static method calls');
    }

    public function getStaticMethodCalls(): int
    {
        return $this->getValue('static method calls');
    }

    public function getNamespaces(): int
    {
        return $this->getCount('namespaces');
    }

    public function getInterfaces(): int
    {
        return $this->getValue('interfaces');
    }

    public function getTraits(): int
    {
        return $this->getValue('traits');
    }

    public function getClasses(): int
    {
        return $this->getAbstractClasses() + $this->getConcreteClasses();
    }

    public function getAbstractClasses(): int
    {
        return $this->getValue('abstract classes');
    }

    public function getConcreteClasses(): int
    {
        return $this->getFinalClasses() + $this->getNonFinalClasses();
    }

    public function getFinalClasses(): int
    {
        return $this->getValue('final classes');
    }

    public function getNonFinalClasses(): int
    {
        return $this->getValue('non-final classes');
    }

    public function getMethods(): int
    {
        return $this->getNonStaticMethods() + $this->getStaticMethods();
    }

    public function getNonStaticMethods(): int
    {
        return $this->getValue('non-static methods');
    }

    public function getStaticMethods(): int
    {
        return $this->getValue('static methods');
    }

    public function getPublicMethods(): int
    {
        return $this->getValue('public methods');
    }

    public function getNonPublicMethods(): int
    {
        return $this->getProtectedMethods() + $this->getPrivateMethods();
    }

    public function getProtectedMethods(): int
    {
        return $this->getValue('protected methods');
    }

    public function getPrivateMethods(): int
    {
        return $this->getValue('private methods');
    }

    public function getFunctions(): int
    {
        return $this->getNamedFunctions() + $this->getAnonymousFunctions();
    }

    public function getNamedFunctions(): int
    {
        return $this->getValue('named functions');
    }

    public function getAnonymousFunctions(): int
    {
        return $this->getValue('anonymous functions');
    }

    public function getConstants(): int
    {
        return $this->getGlobalConstants() + $this->getClassConstants();
    }

    public function getGlobalConstants(): int
    {
        return $this->getValue('global constants');
    }

    public function getPublicClassConstants(): int
    {
        return $this->getValue('public class constants');
    }

    public function getNonPublicClassConstants(): int
    {
        return $this->getValue('non-public class constants');
    }

    public function getClassConstants(): int
    {
        return $this->getPublicClassConstants() + $this->getNonPublicClassConstants();
    }

    public function getTestClasses(): int
    {
        return $this->getValue('test classes');
    }

    public function getTestMethods(): int
    {
        return $this->getValue('test methods');
    }

    /**
     * @return array<string, float|int>
     */
    public function toArray(): array
    {
        return [
            'files'                       => $this->getFiles(),
            'loc'                         => $this->getLines(),
            'lloc'                        => $this->getLogicalLines(),
            'llocClasses'                 => $this->getClassLines(),
            'llocFunctions'               => $this->getFunctionLines(),
            'llocGlobal'                  => $this->getNotInClassesOrFunctions(),
            'cloc'                        => $this->getCommentLines(),
            'ccn'                         => $this->getComplexity(),
            'ccnMethods'                  => $this->getMethodComplexity(),
            'interfaces'                  => $this->getInterfaces(),
            'traits'                      => $this->getTraits(),
            'classes'                     => $this->getClasses(),
            'abstractClasses'             => $this->getAbstractClasses(),
            'concreteClasses'             => $this->getConcreteClasses(),
            'finalClasses'                => $this->getFinalClasses(),
            'nonFinalClasses'             => $this->getNonFinalClasses(),
            'functions'                   => $this->getFunctions(),
            'namedFunctions'              => $this->getNamedFunctions(),
            'anonymousFunctions'          => $this->getAnonymousFunctions(),
            'methods'                     => $this->getMethods(),
            'publicMethods'               => $this->getPublicMethods(),
            'nonPublicMethods'            => $this->getNonPublicMethods(),
            'protectedMethods'            => $this->getProtectedMethods(),
            'privateMethods'              => $this->getPrivateMethods(),
            'nonStaticMethods'            => $this->getNonStaticMethods(),
            'staticMethods'               => $this->getStaticMethods(),
            'constants'                   => $this->getConstants(),
            'classConstants'              => $this->getClassConstants(),
            'publicClassConstants'        => $this->getPublicClassConstants(),
            'nonPublicClassConstants'     => $this->getNonPublicClassConstants(),
            'globalConstants'             => $this->getGlobalConstants(),
            'testClasses'                 => $this->getTestClasses(),
            'testMethods'                 => $this->getTestMethods(),
            'ccnByLloc'                   => $this->getAverageComplexityPerLogicalLine(),
            'llocByNof'                   => $this->getAverageFunctionLength(),
            'methodCalls'                 => $this->getMethodCalls(),
            'staticMethodCalls'           => $this->getStaticMethodCalls(),
            'instanceMethodCalls'         => $this->getNonStaticMethodCalls(),
            'attributeAccesses'           => $this->getAttributeAccesses(),
            'staticAttributeAccesses'     => $this->getStaticAttributeAccesses(),
            'instanceAttributeAccesses'   => $this->getNonStaticAttributeAccesses(),
            'globalAccesses'              => $this->getGlobalAccesses(),
            'globalVariableAccesses'      => $this->getGlobalVariableAccesses(),
            'superGlobalVariableAccesses' => $this->getSuperGlobalVariableAccesses(),
            'globalConstantAccesses'      => $this->getGlobalConstantAccesses(),
            'directories'                 => $this->getDirectories(),
            'classCcnMin'                 => $this->getMinimumClassComplexity(),
            'classCcnAvg'                 => $this->getAverageComplexityPerClass(),
            'classCcnMax'                 => $this->getMaximumClassComplexity(),
            'classLlocMin'                => $this->getMinimumClassLength(),
            'classLlocAvg'                => $this->getAverageClassLength(),
            'classLlocMax'                => $this->getMaximumClassLength(),
            'methodCcnMin'                => $this->getMinimumMethodComplexity(),
            'methodCcnAvg'                => $this->getAverageComplexityPerMethod(),
            'methodCcnMax'                => $this->getMaximumMethodComplexity(),
            'methodLlocMin'               => $this->getMinimumMethodLength(),
            'methodLlocAvg'               => $this->getAverageMethodLength(),
            'methodLlocMax'               => $this->getMaximumMethodLength(),
            'averageMethodsPerClass'      => $this->getAverageMethodsPerClass(),
            'minimumMethodsPerClass'      => $this->getMinimumMethodsPerClass(),
            'maximumMethodsPerClass'      => $this->getMaximumMethodsPerClass(),
            'namespaces'                  => $this->getNamespaces(),
            'ncloc'                       => $this->getNonCommentLines(),
        ];
    }

    private function getAverage(string $key): float
    {
        return $this->divide($this->getSum($key), $this->getCount($key));
    }

    private function getCount(string $key): int
    {
        return isset($this->counts[$key]) ? count($this->counts[$key]) : 0;
    }

    private function getSum(string $key): int
    {
        return isset($this->counts[$key]) ? array_sum($this->counts[$key]) : 0;
    }

    private function getMaximum(string $key): int
    {
        return isset($this->counts[$key]) ? max($this->counts[$key]) : 0;
    }

    private function getMinimum(string $key): int
    {
        return isset($this->counts[$key]) ? min($this->counts[$key]) : 0;
    }

    private function getValue(string $key, mixed $default = 0): mixed
    {
        return $this->counts[$key] ?? $default;
    }

    private function divide(int $x, int $y): float
    {
        return $y !== 0 ? $x / $y : 0;
    }
}
