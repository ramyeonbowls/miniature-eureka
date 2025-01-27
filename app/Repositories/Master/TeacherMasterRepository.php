<?php

namespace App\Repositories\Master;

use App\Models\User;
use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherMasterRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($client_id): Collection
    {
        return DB::table('users as a')
			->select(
				'a.id',
				'b.nik',
				'b.photo',
				'a.name',
				'a.email',
				'b.phone',
				'b.birthday',
				'a.email_verified_at',
				'a.created_at',
				'b.gender'
			)
            ->join('tattr_member as b', function($join) {
                $join->on('a.id', '=', 'b.id');
            })
            ->where('a.client_id', '=', $client_id)
            ->where('a.role', '=', 'teacher')
			->get();
    }

	/**
     * @param object $data
     * @return bool
     */
    public function store(object $data, $client_id): bool
    {
		try{
			$user = $this->createUser($data, $client_id);

			$attr = DB::table('tattr_member')
				->insert([
					'id'            => $user->id,
					'client_id'     => $client_id,
					'nik'           => $data->nik,
					'phone'         => $data->phone,
					'birthday'      => $data->birthday,
					'gender'        => $data->gender,
					'created_at'    => $data->create_date
				]);

			$webmenus = [1, 4, 18, 27, 29];
			for($i=0; $i<count($webmenus); $i++){
				$inserted[] = [
						'username'			=> $user->email,
						'menu_id'			=> $webmenus[$i],
						'create_permission'	=> 1,
						'read_permission'	=> 1,
						'update_permission'	=> 1,
						'delete_permission'	=> 1,
						'print_permission'	=> 1,
						'approve_permission'=> 1,
						'created_at'		=> $data->create_date
				];
			}

			$acl = DB::table('web_menu_acls')
				->insert($inserted);

			return true;
		} catch (\Exception $e) {
			\Log::error('Create teacher failed => ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * @param object $data
     * @return bool
     */
    public function create(object $data, $client_id): bool
    {
		try{
			$user = $this->createUser($data, $client_id);

			$attr = DB::table('tattr_member')
				->insert([
					'id'            => $user->id,
					'client_id'     => $client_id,
					'nik'           => $data->nik,
					'phone'         => $data->phone,
					'birthday'      => $data->birthday,
					'gender'        => $data->gender,
					'created_at'    => $data->create_date
				]);

			$webmenus = [1, 4, 18, 27, 29];
			for($i=0; $i<count($webmenus); $i++){
				$inserted[] = [
						'username'			=> $user->email,
						'menu_id'			=> $webmenus[$i],
						'create_permission'	=> 1,
						'read_permission'	=> 1,
						'update_permission'	=> 1,
						'delete_permission'	=> 1,
						'print_permission'	=> 1,
						'approve_permission'=> 1,
						'created_at'		=> $data->create_date
				];
			}

			$acl = DB::table('web_menu_acls')
				->insert($inserted);

			return true;
		} catch (\Exception $e) {
			\Log::error('Create teacher failed => ' . $e->getMessage());
            return false;
        }
    }

	protected function createUser(object $data, $client_id)
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'role' => 'teacher',
            'flag_approve' => 'Y',
            'email_verified_at' => $data->create_date,
            'created_at' => $data->create_date,
            'client_id' => $client_id
        ]);
    }
	
	/**
     * @param object $data
     * @param string $id
     * @return bool
     */
    public function update(object $data, string $id, $client_id): bool
    {
        return DB::transaction(function () use ($data, $id, $client_id) {
            $check = true;
            $user = User::find($id);

            if (!$user->update(['name' => $data->name, 'updated_at' => $data->modified_date])) {
                $check = false;
            }

            if (!empty($data->password) && $data->password !== 'null' && $data->password !== null) {
                if (!$user->update(['password' => Hash::make($data->password)])) {
                    $check = false;
                }
            }

            $attr = DB::table('tattr_member')
                    ->where('id', $id)
                    ->where('client_id', $client_id)
                    ->update([
                        'nik'           => $data->nik,
                        'phone'         => $data->phone,
                        'birthday'      => $data->birthday,
                        'gender'        => $data->gender,
                        'updated_at'    => $data->modified_date
                    ]);

            if (!$attr) {
                $check = false;
            }
    
            return $check;
        });
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id, $client_id)
    {
        return DB::transaction(function () use ($id, $client_id) {
            $attr = DB::table('tattr_member')
                ->where('client_id', $client_id)
                ->where('id', $id);
            $attr_file = $attr->first();

            if($attr_file->photo!=''){
                @unlink(storage_path('app/public/images/profile/'.$attr_file->photo));
            }

            DB::table('tattr_member')->where('id', $id)->where('client_id', $client_id)->delete();

			$teacher = DB::table('users')
				->where('id', $id)
				->where('client_id', $client_id)
				->where('role', 'teacher')
				->first();

			if ($teacher) {
				DB::table('web_menu_acls')->where('username', $teacher->email)->delete();

				$teacher = DB::table('users')->where('id', $id)->where('client_id', $client_id)->where('role', 'teacher');

				return $teacher->delete();
			}

			return false;
        });
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function check(string $id, $client_id)
    {
        return DB::table('ttrx_read as a')
                ->select([
                    DB::raw('COUNT(DISTINCT a.book_id) AS total')
                ])
                ->where('a.client_id', $client_id)
                ->where('a.user_id', $id)
                ->get();
    }
}