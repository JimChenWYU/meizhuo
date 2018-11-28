<?php

namespace App\Transformers;

use League\Fractal;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class ApplicantTransformer
 * 转换器，负责报名者相关接口数据返回的转换
 * @package App\Transformers
 */
class ApplicantTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [ 'mz_applicants' ];

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * Transform object into a generic array
     *
     * @var $resource
     * @return array
     */
    public function transform($resource)
    {
        return [

            'id' => (int) $resource->id,
			'student_id' => $resource->student_id,
			'name' => $resource->name,
			'major' => $resource->major,
			'phone_num' => $resource->phone_num,
			'grade' => $resource->grade,
			'department' => $resource->department,
			'introduce' => $resource->introduce,
			'created_at' => $resource->created_at,
			'updated_at' => $resource->updated_at,
			
        ];
    }
}
