<?php


namespace App\Services;


use App\EventAudit;

class EventAuditService extends Service {

    public function all($where)
    {
        $qb = $this->getQB($where);
        return $qb->get();
    }

    public function allWithPagination($where){
        $qb = $this->getQB($where);
        return $qb->paginate();
    }

    private function getQB($where) {
        $qb = EventAudit::where($where)
            ->orderBy('updated_at', 'DESC');
        return $qb;
    }
}