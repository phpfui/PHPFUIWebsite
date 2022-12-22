<?php

namespace PHPFUI\InstaDoc\Tests;

trait ConstantsAllowed
	{
	public const CONSTANT = 1;

	public function bar() : int
    {
		return Foo::CONSTANT;
    }
	}

/**
 * A test class with no functionality.
 *
 * <b>It is just to test InstaDoc</b>
 *
 * @author bruce (12/22/2022)
 */
readonly class Test82
	{
	private Status $status;

	public function __construct(private ?Status $enum = Status::Published)
		{
		}

	private function alwaysFalse() : false
		{
    return false;
		}

	protected function alwaysTrue() : true
		{
		return true;
		}

	protected function alwaysNull() : null
		{
		return null;
		}

	public function disjunctiveNormalFormTypes((ConstantsAllowed & Status) | null $post) : void
		{
		}

	public function takeAndReturnEnum(?Status $enum = null) : Status
		{
		return $enum;
		}

	final public function intersectionTypesFinal(\Iterator & \Countable $collection) : never
		{
		exit;
		}
	}
