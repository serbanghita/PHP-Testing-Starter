<?php
namespace UnitTests\Output;

use Examples\Output\Model;
use Examples\Output\View;
use Examples\Output\Controller;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * index is outputting the expected html code for our custom user
     */
    public function testIndexIsOutputtingTheExpectedHtmlCodeForOurCustomUser()
    {
        $expectedOutput = <<<HTML
<section>
    <div class="section">
        My name is <b>SerbanGhita</b>!
    </div>
</section>
HTML;

        $model = new Model();
        $model->setUsername('SerbanGhita');
        $view = new View();
        $c = new Controller($model, $view);

        $this->expectOutputString($expectedOutput);
        $c->index();
    }
}