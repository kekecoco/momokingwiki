<?php

/**
 * @covers Licenses
 */
class LicensesTest extends MediaWikiUnitTestCase
{

    public function testLicenses()
    {
        $str = "
* Free licenses:
** GFDL|Debian disagrees
";

        $lc = new Licenses([
            'fieldname' => 'FooField',
            'type'      => 'select',
            'section'   => 'description',
            'id'        => 'wpLicense',
            'label'     => 'A label text', # Note can't test label-message because $wgOut is not defined
            'name'      => 'AnotherName',
            'licenses'  => $str,
        ]);
        $this->assertInstanceOf(Licenses::class, $lc);
    }
}
