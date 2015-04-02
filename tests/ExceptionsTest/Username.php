<?php
namespace UnitTests\ExceptionsTest;

class Username
{
    const MIN_LENGTH = 5;
    const MAX_LENGTH = 10;
    const FORMAT = '/^[a-z0-9_]+$/is';

    private $username;

    public function __construct($username)
    {
        $this->setUsername($username);
    }

    private function setUsername($username)
    {
        $this->assertNotEmpty($username);
        $this->assertNotTooShort($username);
        $this->assertNotTooLong($username);
        $this->assertValidFormat($username);
        $this->username = $username;
    }

    public function username()
    {
        return $this->username;
    }

    private function assertNotEmpty($username)
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Empty username');
        }
    }

    private function assertNotTooShort($username)
    {
        if (strlen($username) < self::MIN_LENGTH) {
            throw new \InvalidArgumentException(sprintf('Username must be %d characters or more', self::MIN_LENGTH));
        }
    }

    private function assertNotTooLong($username)
    {
        if (strlen($username) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(sprintf('Username must be %d characters or less', self::MAX_LENGTH));
        }
    }

    private function assertValidFormat($username)
    {
        if (preg_match(self::FORMAT, $username) !== 1) {
            throw new \InvalidArgumentException('Invalid username format');
        }
    }
}