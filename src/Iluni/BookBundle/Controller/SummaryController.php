<?php

namespace Iluni\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Iluni\BookBundle\Library\Controller\CommonController;
use Iluni\BookBundle\Form\SummaryFilter;

/**
 * Summary controller.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class SummaryController extends CommonController
{
    public function totalAction(Request $request)
    {
        $filterForm = $this->createForm(new SummaryFilter());

        if ('POST' == $request->getMethod()) {
            $name = $filterForm->getName();
            $params = (array) $request->request->get($name);
        } else {
            $params = array('groupBy' => 1);
        }

        $type = (int) $params['groupBy'];
        $filterForm->bind($params);

        $entities = $this->getTotalEntities($type);
        $rows = $this->transformToChart($entities, $type);

        // note: use OutputWalker for SQL with having clause

        return $this->renderTwig('Detail/Summary:index', array(
            'filter_form'   => $filterForm->createView(),
            'entities'  => $rows
        ));
    }

    private function getTotalEntities($type)
    {
        $entities = null;
        $repository = $this->get('iluni_book.repository.summary');

        switch ($type) {
            case 1: // Community
                $entities = $repository->findTotalCommunity();
                break;
            case 2: // Department
                $entities = $repository->findTotalDepartment();
                break;
            case 3: // Faculty
                $entities = $repository->findTotalFaculty();
                break;
            case 4: // Program
                $entities = $repository->findTotalProgram();
                break;
            case 5: // Class of Year
                $entities = $repository->findTotalClassofYear();
                break;
            case 6: // Community
                $entities = $repository->findTotalAlumniCommunities();
                break;
        }  // switch

        return $entities;
    }

    private function getUrl($entity, $type)
    {
        $routes_by_type = array(
            1 => 'acommunities_filter_community',
            2 => 'acommunities_filter_department',
            3 => 'acommunities_filter_faculty',
            4 => 'acommunities_filter_program',
            5 => 'acommunities_filter_year',
            6 => 'acommunities_filter_community_year'
        );

        $args_by_type = array(
            1 => 'cid',
            2 => 'did',
            3 => 'fid',
            4 => 'pid',
            5 => 'year',
            6 => 'cid'
        );

        $route  = $routes_by_type[$type];
        $arg1   = $args_by_type[$type];

        switch ($type) {
            case 1: // Community
            case 2: // Department
            case 3: // Faculty
            case 4: // Program
                $args = array($arg1 => $entity['id']);
                break;
            case 5: // Class of Year
                $args = array($arg1 => $entity['classYear']);
                break;
            case 6: // Community
                $args = array(
                    $arg1  => $entity['id'],
                    'year' => $entity['classYear']
                );
                break;
        }  // switch

        $url = $this->generateUrl($route, $args);

        return $url;
    }

    private function transformToChart($entities, $type)
    {
        // graph accesories
        $max = 0;
        $sum = 0;

        foreach ($entities as $entity) {
            $total = $entity['total'];
            $sum  += $total;
            $max   = ($max < $total) ? $total : $max;
        }

        $rows = array();
        $colorIndex=1;

        foreach ($entities as $index => $entity) {
            $total = $entity['total'];

            $row = array(
                'total'   => $total,
                'percent' => round(100*$total*100/$sum)/100,
                'width'   => round($total*300/$max),
                'color'   => ($index % 5) + 1,
            );

            $row['url'] = $this->getUrl($entity, $type);

            if ($type==5) {
                $row['name'] = $entity['classYear'];
            } else {
                $row['name'] = $entity['name'];
            }

            $rows[] = $row;
        }

        return $rows;
    }
}

