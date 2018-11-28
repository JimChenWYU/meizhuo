<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 5/9/2017
 * Time: 12:35 PM
 */

namespace App\Http\Controllers\Api;

/**
 * Class Condition
 * Api常用变量或方法配置
 * @package App\Http\Controllers\Api
 */
trait Condition
{
    public static $grade = [ '大一', '大二' ];
    public static $department = [ '移动组', 'Web组', '美工组', '营销策划' ];

    public static $message = [
        'student_id.required' => '请合法填写您的学号',
        'student_id.digits' => '请合法填写您的学号',

        'name.required' => '请合法填写您的姓名',
        'name.string' => '请合法填写您的姓名',
        'name.max' => '请合法填写您的姓名',

        'major.required' => '请合法填写您的专业',
        'major.string' => '请合法填写您的专业',
        'major.max' => '请合法填写您的专业',

        'phone_num.required' => '请合法填写您的联系方式',
        'phone_num.string' => '请合法填写您的联系方式',
        'phone_num.max' => '请合法填写您的联系方式',

        'grade.required' => '请合法选择您的年级',
        'grade.string' => '请合法选择您的年级',

        'department.required' => '请合法选择面试部门',
        'department.string' => '请合法选择面试部门',

        'introduce.string' => '请填写不多于300字的简介',
        'introduce.max' => '请填写不多于300字的简介',
    ];

    public static $group = [
        'android' => '移动组',
        'web' => 'Web组',
        'design' => '美工组',
        'marking' => '营销策划',
    ];

    /**
     * 签到者模板数组
     *
     * @return array
     */
    public function signTemplate()
    {
        static $template = [
            'student_id' => '',
            'name' => '',
            'major' => '',
            'phone_num' => '',
            'grade' => '',
            'department' => '',
            'introduce' => '',

            'has_apply' => 0,
            'status' => 1
        ];

        return $template;
    }

    /**
     * 接受字段数组
     *
     * @return array
     */
    public function acceptParameters()
    {
        static $template = [
            'student_id',
            'name',
            'major',
            'phone_num',
            'grade',
            'department',
            'introduce'
        ];

        return $template;
    }
}