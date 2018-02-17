<?php declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

return [
    // By default when running php-scoper add-prefix, it will prefix all relevant code found in the current working
    // directory. You can however define which files should be scoped by defining a collection of Finders in the
    // following configuration key.
    //
    // For more see: https://github.com/humbug/php-scoper#finders-and-paths
    'finders' => [
        // Rector source
        Finder::create()
            ->files()
            ->notName('*.md')
            ->in('src')
            ->in('packages')
            ->exclude('tests'),
        Finder::create()
            ->files()
            ->in('vendor/friendsofphp/php-cs-fixer/tests/Test')
            ->append([
                'vendor/friendsofphp/php-cs-fixer/tests/TestCase.php',
                'bin/rector',
                'bin/rector_bootstrap.php',
                'composer.json',
                'box.json',
            ]),

        // vendor files
        Finder::create()
            ->files()
            ->ignoreVCS(true)
            ->notName('/LICENSE|.*\\.md|.*\\.dist|Makefile|composer\\.json|composer\\.lock/')
            ->exclude([
                'doc',
                'test',
                'test_old',
                'tests',
                'Tests',
                'vendor-bin',
            ])
            ->in('vendor'),
    ],

    'patchers' => [
        function (string $filePath, string $prefix, string $contents): string {
            if (__DIR__.'/vendor/nette/application/src/compatibility.php' === $filePath) {
                return str_replace('\'Nette\\\\Application\\\\', '\''.$prefix.'\\\\Nette\\\\Application\\\\', $contents);
            }

            return $contents;
        },
    ],
];
