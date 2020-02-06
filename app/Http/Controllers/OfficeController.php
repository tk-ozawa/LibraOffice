<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OfficeService;

class OfficeController extends Controller
{
	private $office;

	function __construct(OfficeService $office)
	{
		$this->office = $office;
	}

	/**
	 * オフィスTOP
	 */
	public function goTop(Request $request)
	{
		// オフィス一覧取得
		$offices = $this->office->getList();

		return view('office.top', compact('offices'));
	}

	/**
	 * オフィスアカウント(ユーザーアカウント)登録画面
	 */
	public function goRegister(Request $request)
	{
		return view('office.add');
	}

	/**
	 * オフィスアカウント(ユーザーアカウント)登録処理
	 */
	public function register(Request $request)
	{
		$input = $request->all();
		$this->office->create($input);
		return redirect(route('office.top'))->with('flashMsg', "オフィスを作成しました");
	}
}
