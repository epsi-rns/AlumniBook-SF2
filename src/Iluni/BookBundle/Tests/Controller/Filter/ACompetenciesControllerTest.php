<?php

namespace Iluni\BookBundle\Tests\Controller\Filter;

use Iluni\BookBundle\Tests\ControllerTestCase;

/**
 * Simple scenario to test filter controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class ACompetenciesControllerTest extends ControllerTestCase
{
    public function testFilterScenario()
    {
        $client = $this->startScenario();

        $url_path = '/acompetencies/categories';
        $this->continueCategoriesScenario($url_path);

        // Prepare Data, fill in the form
        $formName = 'iluni_bookbundle_acompetenciesfilter';
        $formData = array(
            $formName.'[orderBy]'  => 45,
            $formName.'[community][faculty]'  => 4
        );

        $url_path = '/acompetencies/filter';
        $this->continueFilterScenario($url_path, $formData);

        $url_path = '/acompetencies/table?page=1&orderBy=105';
        $this->continueTableScenario($url_path, 'list_edit');
    }
}

