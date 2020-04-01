<?php
/**
 * This file is part of the MathExecutor package
 *
 * (c) Alexander Kiryukhin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace NXP\Classes\Token;

/**
 * @author Bruce Wells <brucekwells@gmail.com>
 */
class TokenStringDoubleQuoted extends AbstractContainerToken
{
    /**
     * @return string
     */
    public static function getRegex()
    {
        return '"([^"]|"")*"';
    }
}
