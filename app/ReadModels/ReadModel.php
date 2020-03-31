<?php

declare(strict_types=1);

namespace App\ReadModels;

use App\Exceptions\WriteOperationIsNotAllowedForReadModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReadModel
 * @package App\ReadModels
 */
class ReadModel extends Model
{
    public $incrementing = false;

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    /**
     * @param Builder $query
     * @return bool|void
     */
    protected function performInsert(Builder $query)
    {
        throw new WriteOperationIsNotAllowedForReadModel();
    }

    /**
     * @param Builder $query
     * @return bool|void
     */
    protected function performUpdate(Builder $query)
    {
        throw new WriteOperationIsNotAllowedForReadModel();
    }

    /**
     * @return void
     */
    protected function performDeleteOnModel(): void
    {
        throw new WriteOperationIsNotAllowedForReadModel();
    }

    /**
     * @return void
     */
    public function truncate(): void
    {
        throw new WriteOperationIsNotAllowedForReadModel();
    }
}
