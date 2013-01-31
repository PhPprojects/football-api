<?php

namespace Knp\ChallengeBundle\Entity;

use Doctrine\ORM\EntityRepository;

class StandingsRepository extends EntityRepository
{
    public function findStandingsFromPeriod($dateFrom, $dateTo)
    {
        $qb = $this->createQueryBuilder('st');
        $qb->Where('st.dateFrom = :dateFrom')
            ->orWhere('st.dateTo = :dateTo')
            ->setParameters(array(
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ))
            ->orderBy('st.place','asc');

        $query = $qb->getQuery();

        return $query->execute();
    }

    public function findStandingsForDate($date)
    {
        $qb = $this->createQueryBuilder('st');
        $qb->Where('st.dateFrom <= :date')
            ->andWhere('st.dateTo >= :date')
            ->setParameter('date', $date);

        $query = $qb->getQuery();

        return $query->execute();
    }
}
