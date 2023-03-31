<?php

namespace PHPFUI\ORM;

class Children extends \PHPFUI\ORM\VirtualField
	{

	public function getValue(array $parameters) : mixed
		{
		$child = array_shift($parameters);
		$childTable = new $child();
		$condition = new \PHPFUI\ORM\Condition();

		foreach ($this->parentRecord->getPrimaryKeys() as $primaryKey => $junk)
			{
			$condition->and($primaryKey, $this->parentRecord->$primaryKey);
			}
		$childTable->setWhere($condition);

		$orderBy = array_shift($parameters);
		if ($orderBy)
			{
			$childTable->addOrderBy($orderBy);
			}

		return $childTable->getRecordCursor();
		}
	}
