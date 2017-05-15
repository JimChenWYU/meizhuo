<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 5/15/2017
 * Time: 4:12 PM
 */

namespace App\Http\Controllers\Traits;

use App\Signer;
use Illuminate\Http\Request;

/**
 * Class TSigner
 * 对签到面试同学查看相关操作
 * @package App\Http\Controllers\Traits
 */
trait TSigner
{
    protected $signer_settings = [
        'root' => 'auth.signer',
    ];
    /**
     * 显示所有面试者
     *
     * @return $this
     */
    public function signer()
    {
        $signerObject = Signer::paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.signer.signers')
            ->with('settings', $this->signer_settings)
            ->with('sign_all', true)
            ->with('departmentName', '所有面试者')
            ->with('department', $signerArray);
    }

    /**
     * 显示安卓面试者
     *
     * @return $this
     */
    public function signerFromAndroid()
    {
        $signerObject = Signer::where('department', '移动组')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.signer.signers')
            ->with('settings', $this->signer_settings)
            ->with('sign_android', true)
            ->with('departmentName', '安卓组面试者')
            ->with('department', $signerArray);
    }

    /**
     * 显示web组面试者
     *
     * @return $this
     */
    public function signerFromWeb()
    {
        $signerObject = Signer::where('department', 'Web组')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.signer.signers')
            ->with('settings', $this->signer_settings)
            ->with('sign_web', true)
            ->with('departmentName', 'Web组面试者')
            ->with('department', $signerArray);
    }

    /**
     * 显示美工组面试者
     *
     * @return $this
     */
    public function signerFromDesign()
    {
        $signerObject = Signer::where('department', '美工组')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.signer.signers')
            ->with('settings', $this->signer_settings)
            ->with('sign_design', true)
            ->with('departmentName', '美工组面试者')
            ->with('department', $signerArray);
    }

    /**
     * 显示营销策划组面试者
     *
     * @return $this
     */
    public function signerFromMarking()
    {
        $signerObject = Signer::where('department', '营销策划')->paginate(10);
        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.signer.signers')
            ->with('settings', $this->signer_settings)
            ->with('sign_marking', true)
            ->with('departmentName', '营销策划面试者')
            ->with('department', $signerArray);
    }

    /**
     * 搜索面试者
     *
     * @param Request $request
     * @return $this
     */
    public function postSearchSigner(Request $request)
    {
        $this->validate($request, [
            'search' => 'required'
        ]);
        $parameters = $request->only(['search']);

        $signerObject = Signer::whereRaw(sprintf("LOCATE('%s', name) > 0", $parameters['search']))
            ->orWhereRaw(sprintf("LOCATE('%s', student_id) > 0", $parameters['search']))->paginate(10);

        $signerArray = $signerObject->toArray();
//        dd($signerArray);
        return view('auth.signer.signers')
            ->with('settings', $this->signer_settings)
            ->with('search', true)
            ->with('departmentName', "搜索 `{$parameters['search']}`")
            ->with('department', $signerArray);
    }

    /**
     * 搜索模板页面重定向
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getSearchSigner()
    {
        return redirect('/auth/signer/');
    }
}