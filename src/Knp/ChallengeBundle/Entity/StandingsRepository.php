<?php

namespace Knp\ChallengeBundle\Entity;

use Doctrine\ORM\EntityRepository;

class StandingsRepository extends EntityRepository
{
    public function getStandings($dateFrom, $dateTo)
    {
        $qb = $this->createQueryBuilder('st');
        $qb->Where('st.dateFrom = :dateFrom')
            ->orWhere('st.dateTo = :dateTo')
            ->setParameters(array(
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ))
            ->orderBy('st.place','desc');

        $query = $qb->getQuery();

        return $query->execute();
    }
}
