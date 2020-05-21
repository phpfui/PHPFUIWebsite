<?php

/**
 * This file is part of the MathExecutor package
 *
 * (c) Alexander Kiryukhin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace NXP;

use NXP\Classes\Calculator;
use NXP\Classes\CustomFunction;
use NXP\Classes\Operator;
use NXP\Classes\Tokenizer;
use NXP\MathExecutorException;
use NXP\Exception\DivisionByZeroException;
use ReflectionException;

/**
 * Class MathExecutor
 * @package NXP
 */
class MathExecutor
{
    /**
     * Available variables
     *
     * @var array
     */
    private $variables = [];

    /**
     * @var Operator[]
     */
    private $operators = [];

    /**
     * @var CustomFunction[]
     */
    private $functions = [];

    /**
     * @var array
     */
    private $cache = [];

    /**
     * Base math operators
     */
    public function __construct()
    {
        $this->addDefaults();
    }

    /**
     * Set default operands and functions
     * @throws ReflectionException
     */
    protected function addDefaults() : void
    {
        foreach ($this->defaultOperators() as $name => $operator) {
            [$callable, $priority, $isRightAssoc] = $operator;
            $this->addOperator(new Operator($name, $isRightAssoc, $priority, $callable));
        }
        foreach ($this->defaultFunctions() as $name => $callable) {
            $this->addFunction($name, $callable);
        }
        $this->variables = $this->defaultVars();
    }

    /**
     * Get the default operators
     *
     * @return array of class names
     */
    protected function defaultOperators() : array
    {
        return [
            '+' => [
                function ($a, $b) {
                    return $a + $b;
                },
                170,
                false
            ],
            '-' => [
                function ($a, $b) {
                    return $a - $b;
                },
                170,
                false
            ],
            '*' => [
                function ($a, $b) {
                    return $a * $b;
                },
                180,
                false
            ],
            '/' => [
                function ($a, $b) {
                    if ($b == 0) {
                        throw new DivisionByZeroException();
                    }
                    return $a / $b;
                },
                180,
                false
            ],
            '^' => [
                function ($a, $b) {
                    return pow($a, $b);
                },
                220,
                true
            ],
            '&&' => [
                function ($a, $b) {
                    return $a && $b;
                },
                100,
                false
            ],
            '||' => [
                function ($a, $b) {
                    return $a || $b;
                },
                90,
                false
            ],
            '==' => [
                function ($a, $b) {
                    return $a == $b;
                },
                140,
                false
            ],
            '!=' => [
                function ($a, $b) {
                    return $a != $b;
                },
                140,
                false
            ],
            '>=' => [
                function ($a, $b) {
                    return $a >= $b;
                },
                150,
                false
            ],
            '>' => [
                function ($a, $b) {
                    return $a > $b;
                },
                150,
                false
            ],
            '<=' => [
                function ($a, $b) {
                    return $a <= $b;
                },
                150,
                false
            ],
            '<' => [
                function ($a, $b) {
                    return $a < $b;
                },
                150,
                false
            ],
        ];
    }

    /**
     * Add operator to executor
     *
     * @param Operator $operator
     * @return MathExecutor
     */
    public function addOperator(Operator $operator) : self
    {
        $this->operators[$operator->operator] = $operator;
        return $this;
    }

    /**
     * Gets the default functions as an array.  Key is function name
     * and value is the function as a closure.
     *
     * @return array
     */
    protected function defaultFunctions() : array
    {
        return [
            'abs' => function ($arg) {
                return abs($arg);
            },
            'acos' => function ($arg) {
                return acos($arg);
            },
            'acosh' => function ($arg) {
                return acosh($arg);
            },
            'asin' => function ($arg) {
                return asin($arg);
            },
            'atan' => function ($arg) {
                return atan($arg);
            },
            'atan2' => function ($arg1, $arg2) {
                return atan2($arg1, $arg2);
            },
            'atanh' => function ($arg) {
                return atanh($arg);
            },
            'atn' => function ($arg) {
                return atan($arg);
            },
            'avg' => function ($arg1, $arg2) {
                return ($arg1 + $arg2) / 2;
            },
            'bindec' => function ($arg) {
                return bindec($arg);
            },
            'ceil' => function ($arg) {
                return ceil($arg);
            },
            'cos' => function ($arg) {
                return cos($arg);
            },
            'cosh' => function ($arg) {
                return cosh($arg);
            },
            'decbin' => function ($arg) {
                return decbin($arg);
            },
            'dechex' => function ($arg) {
                return dechex($arg);
            },
            'decoct' => function ($arg) {
                return decoct($arg);
            },
            'deg2rad' => function ($arg) {
                return deg2rad($arg);
            },
            'exp' => function ($arg) {
                return exp($arg);
            },
            'expm1' => function ($arg) {
                return expm1($arg);
            },
            'floor' => function ($arg) {
                return floor($arg);
            },
            'fmod' => function ($arg1, $arg2) {
                return fmod($arg1, $arg2);
            },
            'hexdec' => function ($arg) {
                return hexdec($arg);
            },
            'hypot' => function ($arg1, $arg2) {
                return hypot($arg1, $arg2);
            },
            'if' => function ($expr, $trueval, $falseval) {
                if ($expr === true || $expr === false) {
                    $exres = $expr;
                } else {
                    $exres = $this->execute($expr);
                }
                if ($exres) {
                    return $this->execute($trueval);
                } else {
                    return $this->execute($falseval);
                }
            },
            'intdiv' => function ($arg1, $arg2) {
                return intdiv($arg1, $arg2);
            },
            'log' => function ($arg) {
                return log($arg);
            },
            'log10' => function ($arg) {
                return log10($arg);
            },
            'log1p' => function ($arg) {
                return log1p($arg);
            },
            'max' => function ($arg1, $arg2) {
                return max($arg1, $arg2);
            },
            'min' => function ($arg1, $arg2) {
                return min($arg1, $arg2);
            },
            'octdec' => function ($arg) {
                return octdec($arg);
            },
            'pi' => function () {
                return pi();
            },
            'pow' => function ($arg1, $arg2) {
                return pow($arg1, $arg2);
            },
            'rad2deg' => function ($arg) {
                return rad2deg($arg);
            },
            'round' => function ($arg) {
                return round($arg);
            },
            'sin' => function ($arg) {
                return sin($arg);
            },
            'sinh' => function ($arg) {
                return sinh($arg);
            },
            'sqrt' => function ($arg) {
                return sqrt($arg);
            },
            'tan' => function ($arg) {
                return tan($arg);
            },
            'tanh' => function ($arg) {
                return tanh($arg);
            },
            'tn' => function ($arg) {
                return tan($arg);
            }
        ];
    }

    /**
     * Execute expression
     *
     * @param $expression
     * @return number
     * @throws Exception\IncorrectExpressionException
     * @throws Exception\IncorrectBracketsException
     * @throws Exception\UnknownOperatorException
     * @throws Exception\UnknownVariableException
     */
    public function execute(string $expression)
    {
        $cachekey = $expression;
        if (!array_key_exists($cachekey, $this->cache)) {
            $tokens = (new Tokenizer($expression, $this->operators))->tokenize()->buildReversePolishNotation();
            $this->cache[$cachekey] = $tokens;
        } else {
            $tokens = $this->cache[$cachekey];
        }
        $calculator = new Calculator($this->functions, $this->operators);
        return $calculator->calculate($tokens, $this->variables);
    }

    /**
     * Add function to executor
     *
     * @param string $name Name of function
     * @param callable $function Function
     * @param int $places Count of arguments
     * @return MathExecutor
     * @throws ReflectionException
     */
    public function addFunction(string $name, ?callable $function = null, ?int $places = null) : self
    {
        $this->functions[$name] = new CustomFunction($name, $function, $places);
        return $this;
    }

    /**
     * Returns the default variables names as key/value pairs
     *
     * @return array
     */
    protected function defaultVars() : array
    {
        return [
            'pi' => 3.14159265359,
            'e' => 2.71828182846
        ];
    }

    /**
     * Get all vars
     *
     * @return array
     */
    public function getVars() : array
    {
        return $this->variables;
    }

    /**
     * Get a specific var
     *
     * @param  string $variable
     * @return integer|float
     * @throws UnknownVariableException
     */
    public function getVar(string $variable)
    {
        if (!isset($this->variables[$variable])) {
          throw new UnknownVariableException("Variable ({$variable}) not set");
        }
        return $this->variables[$variable];
    }

    /**
     * Add variable to executor
     *
     * @param  string $variable
     * @param  integer|float $value
     * @return MathExecutor
     * @throws MathExecutorException
     */
    public function setVar(string $variable, $value) : self
    {
        if (!is_numeric($value)) {
            throw new MathExecutorException("Variable ({$variable}) value must be a number ({$value}) type ({gettype($value)})");
        }
        $this->variables[$variable] = $value;
        return $this;
    }

    /**
     * Add variables to executor
     *
     * @param  array $variables
     * @param  bool $clear Clear previous variables
     * @return MathExecutor
     * @throws \Exception
     */
    public function setVars(array $variables, bool $clear = true) : self
    {
        if ($clear) {
            $this->removeVars();
        }
        foreach ($variables as $name => $value) {
            $this->setVar($name, $value);
        }
        return $this;
    }

		/**
     * Remove variable from executor
     *
     * @param  string $variable
     * @return MathExecutor
     */
    public function removeVar(string $variable) : self
    {
        unset ($this->variables[$variable]);
        return $this;
    }

    /**
     * Remove all variables
     * @return MathExecutor
     */
    public function removeVars() : self
    {
        $this->variables = [];
        return $this;
    }

    /**
     * Get all registered operators to executor
     *
     * @return array of operator class names
     */
    public function getOperators()
    {
        return $this->tokenFactory->getOperators();
    }

    /**
     * Get all registered functions
     *
     * @return array containing callback and places indexed by
     *         function name
     */
    public function getFunctions() : array
    {
        return $this->tokenFactory->getFunctions();
    }

    /**
     * Set division by zero returns zero instead of throwing DivisionByZeroException
     *
     * @return MathExecutor
     */
    public function setDivisionByZeroIsZero() : self
    {
        $this->addOperator(new Operator("/", false, 180, function ($a, $b) {
            if ($b == 0) {
                return 0;
            }
            return $a / $b;
        }));
        return $this;
    }

    public function __clone()
    {
        $this->addDefaults();
    }
}
