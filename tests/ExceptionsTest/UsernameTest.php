<?php

use UnitTests\ExceptionsTest\Username;

class UsernameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * setting a valid username will return the expected username string
     */
    public function testSettingAValidUsernameWillReturnTheExpectedUsernameString()
    {
        $inputUsername = 'serbangg';
        $u = new Username($inputUsername);
        $this->assertEquals($inputUsername, $u->username());
    }

    /**
     * setting an empty username will throw an exception
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Empty username
     */
    public function testSettingAnEmptyUsernameWillThrowAnException()
    {
        $inputUsername = '';
        $u = new Username($inputUsername);
    }

    /**
     * setting a short username will throw an exception
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /Username must be \d characters or more/
     */
    public function testSettingAShortUsernameWillThrowAnException()
    {
        $inputUsername = 'ser';
        $u = new Username($inputUsername);
    }

    /**
     * setting a long username will throw an exception
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /Username must be \d+ characters or less/
     */
    public function testSettingALongUsernameWillThrowAnException()
    {
        $inputUsername = 'serbanghita';
        $u = new Username($inputUsername);
    }

    /**
     * setting a username in an invalid format will throw an exception
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid username format
     */
    public function testSettingAUsernameInAnInvalidFormatWillThrowAnException()
    {
        $inputUsername = 'serb*n';
        $u = new Username($inputUsername);
    }

    /**
     * List of invalid format usernames.
     * @return array
     */
    public function invalidFormatUsernames()
    {
        return array(
            array('serb-an'),
            array('s+rban'),
            array('$3rb4n'),
            array('^erban'),
            array('serb#n'),
            array('~er(b)an'),
            array('s rban'),
        );
    }

    /**
     * setting a username in an invalid format using a provider of usernames will throw an exception
     * @dataProvider invalidFormatUsernames
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid username format
     */
    public function testSettingAUsernameInAnInvalidFormatUsingAProviderOfUsernamesWillThrowAnException($inputUsername)
    {
        $u = new Username($inputUsername);
    }
}