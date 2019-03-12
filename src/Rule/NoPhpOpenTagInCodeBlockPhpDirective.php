<?php

declare(strict_types=1);

/*
 * This file is part of DOCtor-RST.
 *
 * (c) Oskar Stark <oskarstark@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Rule;

use App\Handler\RulesHandler;
use App\Rst\RstParser;

class NoPhpOpenTagInCodeBlockPhpDirective extends AbstractRule implements Rule
{
    public static function getGroups(): array
    {
        return [RulesHandler::GROUP_SONATA, RulesHandler::GROUP_SYMFONY];
    }

    public function check(\ArrayIterator $lines, int $number)
    {
        $lines->seek($number);
        $line = $lines->current();

        if (!RstParser::codeBlockDirectiveIsTypeOf($line, RstParser::CODE_BLOCK_PHP, true)
            && !RstParser::codeBlockDirectiveIsTypeOf($line, RstParser::CODE_BLOCK_PHP_ANNOTATIONS, true)) {
            return;
        }

        $lines->next();
        $lines->next();

        // check if next line is "<?php"
        $nextLine = $lines->current();

        if ('<?php' === RstParser::clean($nextLine)) {
            return sprintf('Please remove PHP open tag after "%s" directive', $line);
        }
    }
}
