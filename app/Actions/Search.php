<?php

namespace App\Actions;

class Search
{
    /**
     * Invoke the search action.
     *
     * @param string $modelName
     * @param array $searchOptions
     * @param array $relationships
     * @param array $joinData
     * @param array $whereNot
     *
     * @return object
     *
     * @SuppressWarnings(PHPMD)
     */
    public function __invoke(String $modelName, array $searchOptions, array $relationships = null, array $joinData = null, array $whereNot = null, array $where = null)
    {
        $model = $modelName;
        $query = $model::query();

        if ($relationships) {
            foreach ($relationships as $item) {
                $query->with($item);
            }
        }

        if ($whereNot) {
            foreach ($whereNot as $key => $item) {
                if (is_array($item)) {
                    foreach ($item as $value) {
                        $query->where($key, '!=', $value);
                    }
                }

                if (! is_array($item)) {
                    $query->where($key, '!=', $item);
                }
            }
        }

        if ($where) {
            foreach ($where as $key => $item) {
                $query->where($key, $item);
            }
        }

        if ($searchOptions['keyword'] != '') {
            $keyword = $searchOptions['keyword'];
            $query->where(function ($query) use ($searchOptions, $keyword) {
                $relation = null;
                $relationKeywordOptions = [];

                if (isset($searchOptions['relation'])) {
                    $relation = $searchOptions['relation'];
                    $relationKeywordOptions = $searchOptions['relationKeywordOptions'];
                }

                if (! $relation) {
                    $keywordOptions = $searchOptions['keywordOptions'];

                    foreach ($keywordOptions as $column) {
                        $query->orWhere($column, 'like', '%'.$keyword.'%');
                    }
                }

                if ($relation) {
                    foreach ($relationKeywordOptions as $column) {
                        $query->orWhereHas($relation, function ($query) use ($keyword, $column) {
                            $query->where($column, 'like', '%'.$keyword.'%');
                        });
                    }
                }
            });
        }

        if (isset($searchOptions['filterOptions']) && $searchOptions['filterOptions']) {
            foreach ($searchOptions['filterOptions'] as $column => $value) {
                if ($value != '') {
                    $relation = false;
                    if ($joinData) {
                        foreach ($joinData as $key => $option) {
                            if (isset($option['filterFields'][$column])) {
                                $relation = true;
                                $relationshipName = $searchOptions['relation'];
                                $relationColumn = $option['filterFields'][$column];

                                $query->orWhereHas($relationshipName, function ($query) use ($value, $relationColumn) {
                                    $query->where($relationColumn, $value);
                                });
                            }
                        }
                    }

                    if (! $relation) {
                        $query->where($column, $value);
                    }
                }
            }
        }

        if (isset($searchOptions['rangeOptions']) && $searchOptions['rangeOptions']) {
            foreach ($searchOptions['rangeOptions'] as $column => $range) {
                if ($range['from'] != '') {
                    $query->where($column, '>=', $range['from']);
                }

                if ($range['to'] != '') {
                    $query->where($column, '<=', $range['to']);
                }
            }
        }

        if (isset($searchOptions['sortOption']) && $searchOptions['sortOption'] != '') {
            $relationSort = false;

            if ($joinData) {
                foreach ($joinData as $key => $option) {
                    if ($key == $searchOptions['sortOption']) {
                        $relationSort = true;
                        $relationModel = $option['relation'];
                        $sortOrder = $searchOptions['sortOrder'];

                        $query->orderBy($relationModel::select($option['field'])
                    ->whereColumn($option['table'].'.'.$option['tableField'], $option['relationTable'].'.'.$option['relationField']), $sortOrder);
                    }
                }
            }

            if (! $relationSort) {
                $query->orderBy($searchOptions['sortOption'], $searchOptions['sortOrder']);
            }
        }

        if ($searchOptions['hidePagination'] == 'true') {
            return $query->get();
        }

        return $query->paginate($searchOptions['perPageCount']);
    }
}
