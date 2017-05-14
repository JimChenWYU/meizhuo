<?php

namespace App\Http\Controllers\Api;

use App\Applicant;
use App\Signer;
use Illuminate\Http\Request;

class SignController extends ApiController
{
    use Condition;

    /**
     * 签到成功
     *
     * @param Request $request
     * @return mixed
     */
    public function sign(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required | digits:10',
            'name' => 'required | string | max:8',
            'department' => 'required | string | in:' . implode(',', self::$department),
        ]);

        $info = $request->only($this->acceptParameters());

        // 是否网上报名
        $hasApply = false;
        $person = [];

        $personObject = Applicant::where('student_id', $info['student_id'])
            ->where('department', $info['department'])->select($this->acceptParameters())->first();

        if ($hasApply = !is_null($personObject)) {
            $person = array_merge($this->signTemplate(),
                array_add($personObject->toArray(), 'has_apply', (int) $hasApply));
        } else {
            $person = array_merge($this->signTemplate(), $info);
        }

        if (is_null($first = Signer::whereStudentId($info['student_id'])
            ->whereDepartment($info['department'])
            ->first())) {
            Signer::create($person);
        }

        return $this->respondWithArray($this->getSignersArray());
    }

    /**
     * 签到记录 按组别分类
     *
     * @return mixed
     */
    public function getSignersByDepartment()
    {
//        dd($this->getSignersArray());
        return $this->respondWithArray($this->getSignersArray());
    }

    /**
     * 删除队列的签到者
     *
     * @param Request $request
     * @return mixed
     */
    public function deleteSignersById(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ], [
            'id.required' => '缺少id'
        ]);

        $parameters = $request->all();

        Signer::destroy($parameters['id']);

        return $this->getSignersByDepartment();
    }

    /**
     * 获取签到者列表
     *
     * @return array
     */
    public function getSignersArray()
    {
        $list = Signer::whereIn('status', [1, 2, 3])->orderBy('created_at', 'asc')->get()->toArray();
//        $list = \DB::select("SELECT * FROM mz_signers");
        $groupByDepartment = [
            'android' => [],
            'web' => [],
            'design' => [],
            'marking' => [],
        ];

        array_walk($list, function ($arr) use (&$groupByDepartment){
            switch ($arr['department']) {
                case self::$group['android']:
                    $groupByDepartment['android'][] = $arr;
                    break;
                case self::$group['web']:
                    $groupByDepartment['web'][] = $arr;
                    break;
                case self::$group['design']:
                    $groupByDepartment['design'][] = $arr;
                    break;
                case self::$group['marking']:
                    $groupByDepartment['marking'][] = $arr;
                    break;
            }
        });

        return (array) $groupByDepartment;
    }

    /**
     * 重置签到者的状态
     *
     * @param Request $request
     * @return mixed
     */
    public function restoreSignerStatus(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ], [
            'id.required' => '缺少id'
        ]);

        $parameters = $request->all();

        Signer::where('id', $parameters['id'])->update([ 'status' => 1 ]);

        return $this->getSignersByDepartment();
    }
}
