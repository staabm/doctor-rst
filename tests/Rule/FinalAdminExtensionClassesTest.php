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

namespace App\Tests\Rule;

use App\Rule\FinalAdminExtensionClasses;
use App\Tests\RstSample;
use PHPUnit\Framework\TestCase;

class FinalAdminExtensionClassesTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider checkProvider
     */
    public function check(?string $expected, RstSample $sample)
    {
        $this->assertSame(
            $expected,
            (new FinalAdminExtensionClasses())->check($sample->getContent(), $sample->getLineNumber())
        );
    }

    public function checkProvider()
    {
        return [
            [
                'Please use "final" for AdminExtension class',
                new RstSample('class TestExtension extends AbstractAdminExtension'),
            ],
            [
                'Please use "final" for AdminExtension class',
                new RstSample('    class TestExtension extends AbstractAdminExtension'),
            ],
            [
                null,
                new RstSample('final class TestExtension extends AbstractAdminExtension'),
            ],
        ];
    }
}
