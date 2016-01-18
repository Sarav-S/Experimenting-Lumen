<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Transformers\UserTransformer;
use App\User;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

	use Helpers;

	public function index(Request $request) {

		if ( !$limit = $request->get('limit') ) {
			$limit = 25;
		}

		if ( $currentPage = $request->get('page') ) {

			Paginator::currentPageResolver(function() use ($currentPage) {
			    return $currentPage;
			});
		}

		$users = User::paginate($limit);

        return $this->response->paginator($users, new UserTransformer);
	}

	public function show(Request $request, $id) {

		$user = User::findorfail($id);

		return $this->response->item($user, new UserTransformer)->setStatusCode(200);
	}

	public function create(Request $request) {

		$validator = \Validator::make($request->all(), [
			'email'    => 'required|email|unique:users',
			'name'     => 'required',
			'password' => 'required|min:6'
		]);

		if ($validator->fails()) {
			throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
		}

		$user = User::create([
			'email'    => $request->get('email'),
			'name'     => $request->get('name'),
			'password' => Hash::make($request->get('password'))
		]);

		if ( $user ) {
			return $this->response->item($user, new UserTransformer)->setStatusCode(200);
		} else {
			return $this->response->array(['message' => 'Unable to create user. Please try again', 'status' => 200]);
		}
	}

	public function update(Request $request, $id) {

		$validator = \Validator::make($request->all(), [
			'id'       => 'required',
			'email'    => 'required|email|unique:users',
			'name'     => 'required',
			'password' => 'min:6'
		]);

		if ($validator->fails()) {
			throw new StoreResourceFailedException('Could not able to update user.', $validator->errors());
		}

		$user = User::findorfail($id);

		$user->email    = $request->get('email');
		$user->name     = $request->get('name');

		if ($request->get('password')) {
			$user->password = Hash::make($request->get('password'));
		}

		if ( $user->save() ) {
			return $this->response->array(['message' => 'User has been updated successfully', 'status' => 200]);
		} else {
			return $this->response->array(['message' => 'Unable to update user. Please try again', 'status' => 200]);
		}
	}

	public function delete(Request $request, $id) {

		if ( $user = User::find($id)->delete() ) {
			return $this->response->array(['message' => 'User has been deleted successfully', 'status' => 200]);
		} else {
			return $this->response->array(['message' => 'Unable to delete user. Please try again', 'status' => 200]);
		}
	}
}