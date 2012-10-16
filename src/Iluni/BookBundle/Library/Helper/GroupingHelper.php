<?php

namespace Iluni\BookBundle\Library\Helper;

class GroupingHelper
{
    protected $entities;
    protected $groups;

    public function __construct($entities)
    {
        $this->entities = $entities;
    }

    public function group($order_by_id)
    {
        $this->groups = array();
        $key = '';

        foreach ($this->entities as $entity) {

            // Limitation Issue: 26.1.9. Persist Keys of Collections
            // use HYDRATE_SCALAR to avoid persisting collection

            $choice_ids1 = array(101, 102, 103, 104, 105);
            $choice_ids2 = array(111, 112, 113, 114, 115);

            if (in_array($order_by_id, $choice_ids1)) {
                // temporary solution!!

                // special treatment for Doctrine\ORM\PersistentCollection
                $communities = $entity->getAlumni()->getACommunities();
                foreach ($communities as $index => $community) {
                    $key = $this->getKey($entity, $order_by_id, $index);
                    $this->groups[$key][] = $entity;
                }
            } elseif (in_array($order_by_id, $choice_ids2)) {
                // temporary solution!!

                // special treatment for Doctrine\ORM\PersistentCollection
                $communities = $entity->getACommunities();
                foreach ($communities as $index => $community) {
                    $key = $this->getKey($entity, $order_by_id, $index);
                    $this->groups[$key][] = $entity;
                }
            } else {
                // do it normally
                $key = $this->getKey($entity, $order_by_id);
                $this->groups[$key][] = $entity;
            }
        }

        ksort($this->groups);
        return $this->groups;
    }

    private function getKey($entity, $order_by_id, $index = 0)
    {
        if (in_array($order_by_id, array(101, 102, 103, 104, 105))) {
            $communities = $entity->getAlumni()->getACommunities();
        }

        if (in_array($order_by_id, array(111, 112, 113, 114, 115))) {
            $communities = $entity->getACommunities();
            var_dump($communities);
        }


        switch ($order_by_id)
        {
            /* Never ever group any ID's!
            case 1:
                $key = $entity->get('aid');
                break;
            case 2:
                $key = $entity->get('cid');
                break;
            case 3:
                $key = $entity->get('org_id');
                break;
            case 4:
                $key = $entity->get('mid');
                break;
            case 5:
                $key = $entity->get('did');
                break;
            case 6:
                $key = $entity->get('lid');
                break;
            */

            /* Not grouping either
            case 10: Any total count
            case 11:
                $key = $entity->get('created');
                break;
            case 12:
                $key = $entity->get('updated');
                break;
            */
            case 21:
                $key = strtoupper(substr($entity->getAlumni(), 0, 1));
                break;
            case 23:
                $key = strtoupper(substr($entity->getOrganization(), 0, 1));
                break;
            case 24:
                $key = strtoupper(substr($entity->getName(), 0, 1));
                break; // Alumna/us
            case 25:
                $key = strtoupper(substr($entity->getName(), 0, 1));
                break; // Organization
            case 26:
                $key = strtoupper(substr($entity->getAOMap()->getAlumni(), 0, 1));
                break; // Alumna/us
            case 27:
                $key = strtoupper(substr($entity->getAOMap()->getOrganization(), 0, 1));
                break; // Organization
            /* Not grouping either
            case 30:
                $key = $entity->get('product');
                break;
            */
            /* Not grouping either
            case 41:
                $key = $entity->get('certification');
                break;
            case 42:
                $key = $entity->get('institution');
                break;
            case 44:
                $key = $entity->get('organization');
                break;
            */
            case 45:
                $key = $entity->getCompetency();
                break;
            case 46:
                $key = $entity->getBizField();
                break;
            case 47:
                $key = $entity->getContactType();
                break;
            /* Not grouping either
            case 60:
                $key = $entity->get('address');
                break;
            case 61:
                $key = $entity->get('region');
                break;
            */
            case 63:
                $key = $entity->getCountry();
                break;
            case 64:
                $key = $entity->getProvince();
                break;
            case 65:
                $key = $entity->getDistrict();
                break;
            /* Not grouping either
            case 66:
                $key = $entity->get('postal_code');
                break;
            case 67:
                $key = $entity->get('street');
                break;
            case 68:
                $key = $entity->get('area');
                break;
            case 69:
                $key = $entity->get('building');
                break;
            */
            case 71:
                $key = $entity->getGender();
                break;

            /* Not grouping either
            case 73:
                $result = $row->get('birthdate');
                break;
            case 74:
                $result = $row->get('a_day');
                break;
            */
            // case is alumni descendant
            case 75:
                $result = $this->months[$row->get('a_month')];
                break;
            case 76:
                $result = $row->get('a_year');
                break;
            case 77:
                $result = $this->weekdays[$row->get('a_weekday')];
                break;
            case 81:
                $key = $entity->getCommunity();
                break;
            case 82:
                $key = $entity->getDepartment();
                break;
            case 83:
                $key = $entity->getFaculty();
                break;
            case 84:
                $key = $entity->getProgram();
                break;
            case 85:
                $key = $entity->getClassYear();
                break;
            case 91:
                $key = $entity[$index]->getName();
                break;
            case 92:
                $key = $entity[$index]->getDepartment();
                break;
            case 93:
                $key = $entity[$index]->getFaculty();
                break;
            case 94:
                $key = $entity[$index]->getProgram();
                break;
            //case 91:
            //    $key = $entity->get('source');
            //    break;
            case 101:
                $key = $communities[$index]->getCommunity();
                break;
            case 102:
                $key = $communities[$index]->getDepartment();
                break;
            case 103:
                $key = $communities[$index]->getFaculty();
                break;
            case 104:
                $key = $communities[$index]->getProgram();
                break;
            case 105:
                $key = $communities[$index]->getClassYear();
                break;
            // case 111..115 is alumni descendant
            case 111:
                $key = $communities[$index]->getCommunity();
                break;
            case 112:
                $key = $communities[$index]->getDepartment();
                break;
            case 113:
                $key = $communities[$index]->getFaculty();
                break;
            case 114:
                $key = $communities[$index]->getProgram();
                break;
            case 115:
                $key = $communities[$index]->getClassYear();
                break;
            default:
                $key ='';
        }

        if (is_object($key)) {
            $key = $key->getName();
        }

        return $key;
    }
}

