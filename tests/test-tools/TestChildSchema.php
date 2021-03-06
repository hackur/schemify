<?php
/**
 * A dummy schema that extends Thing.
 *
 * Note: The ThingTest::testGetPropertyListInheritsParentValues() method relies on these values,
 * to avoid manipulating a bunch of static, protected properties. Do not change $properties or
 * $removeProperties without updating the tests accordingly!
 */

namespace Schemify\Schemas;

class TestChildSchema extends Thing {

	protected static $properties = array(
		'childFoo',
		'childBar',
		'childBaz',
	);
}
