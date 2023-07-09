<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use RuntimeException;

class BaseService
{

    public function getModel(): Model
    {
        throw new RuntimeException('Not Implemented');
    }


    public function getQuery(): ?Builder
    {
        return $this
            ->getModel()
            ->query();
    }
    /**
     * @throws NotFoundException
     */
    public function findById(int $id, array $columns = ['*'], array $withRelations= []): Model|Collection|null
    {
        $result = $this->getQuery()
            ->with($withRelations)
            ->find($id, $columns);
        if (!$result)
            throw new NotFoundException(trans('lang.not_found'));
        return  $result ;
    }

    public function findByIds(array $id, array $columns = ['*']): Collection|array
    {
        return $this->getQuery()->find(Arr::wrap($id), $columns);
    }
}
