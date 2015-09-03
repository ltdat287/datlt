<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\UserSearchFormRequest;
use App\Http\Requests\UserAddFormRequest;
use Input;
use App\Helpers\MemberHelper;
use Session;
use Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //List user with non disabled DESC
        $users = User::getUsers();
        $data = array(
            'users' => $users,
        );

        return view('members.top', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Clear user session.
        Session::forget('user');
        
        // create array roles to display
        $roles = array(
            'admin' => ADMIN,
            'boss' => BOSS,
            'employee' => EMPLOYEE
        );
        
        // Get bosses
        $bosses = User::getBosses();

        // Get user session
        $user = Session::get('user');
        
        // Build data for views
        $data = array(
            'roles' => $roles,
            'bosses' => $bosses,
            'user' => $user
        );

        return view('members.add', $data);
    }

    /**
     * [POST] Show the member add confirm view.
     *
     * @param MemberAddFormRequest $request            
     * @return \Illuminate\View\$this
     */
    public function add_conf(UserAddFormRequest $request)
    {
        // Get user data
        $data = self::_confirmUser($request);
        
        return view('members.add_conf', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Get user from session
        $user = Session::get('user');
        
        if (isset(Input::all()['back']) || empty($user)) {
            return Redirect::route('add');
        } else {
            $record = new User();
            $record = self::_saveUser($record, $user);
            
            // Clear session
            Session::forget('user');
            
            $message = self::_linkToDetail($record->id) . trans('として追加しました。');
            $data = array(
                'label' => trans('追加（完了）'),
                'message' => $message
            );
            
            return view('members.common.member_comp', $data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the page search user 
     * @param  UserSearchFormRequest $request [/search?{search_query}]
     * @return [view ('members.search')] 
     */
    public function search(UserSearchFormRequest $request)
    {
        $users = null;
        $arr_cons = $arr_vals = null;
        $arr_define = array('name', 'email', 'kana', 'telephone_no');
        
        // Check roles checked
        $user_ids = array();
        $arr_checked = ['admin', 'boss', 'employ'];
        foreach ($arr_checked as $checked)
        {
            if (Input::has($checked) && Input::get($checked) == 1)
            {
                $users = User::getUsers()->role($checked)->get();
                foreach ($users as $user)
                {
                    if (! in_array($user->id, $user_ids))
                    {
                        $user_ids[] = $user->id;
                    }
                }
            }
            
        }
        
        //Check has value delete and decode JSON to ARRAY; 
        if (Input::has('putValdel')) 
        {
            $Json2Array = json_decode(Input::get('putValdel'));
            foreach ($Json2Array as $user_id) {
                $role = User::where('id', '=', $user_id)->getFirstRole();
                dd($role);
                $user = User::where('id', '=', $user_id)->delete();
            }
        }

        /*  */
        foreach ($arr_define as $define)
        {
            if (Input::has($define))
            {
                $arr_cons[] = $define . ' = ?';
                $arr_vals[] = Input::get($define);
            }
        }
        
        // Check conditions exists.
        if ($arr_cons)
        {
            $cons = implode(' AND ', $arr_cons);
        }
        
        // Get users with user ids.
        $users = User::getUsers();
        
        // Only listing employ of current user own
        if (MemberHelper::getCurrentUserRole() == 'boss')
        {
            $users->where('boss_id', '=', Auth::user()->id);
        }
        
        if (count($user_ids))
        {
            $users = $users->whereIn('id', $user_ids);
        }
        
        // Check exists search conditions.
        if (count($arr_cons))
        {
            $users = $users->whereRaw($cons, $arr_vals);
        }
        
        // Paginate users.
        if (count($users))
        {
            $users = $users->paginate(VP_LIMIT_PAGINATE)->setPath('search');
        }
        
        // Get role.
        $roles = Role::all();
        
        // Build data for view.
        $data = array(
            'users' => $users,
            'roles' => $roles
        );
        
        return view('members.search', $data);
    }

    /**
     * prepare user data for confirm view.
     * 
     * @param object $request
     * @return array
     */
    private static function _confirmUser($request)
    {
        // Prepare cache data.
        $user = new \stdClass;
        $user->email              = $request->get('email');
        $user->email_confirmation = $request->get('email_confirmation');
        $user->name               = $request->get('name');
        $user->kana               = $request->get('kana');
        $user->password           = $request->get('password');
        $user->telephone_no       = $request->get('telephone_no');
        $user->birthday           = $request->get('birthday');
        $user->note               = ($request->get('note')) ? $request->get('note') : '';
        $user->role             = $request->get('use_role');

        if (MemberHelper::getCurrentUserRole() == 'boss')
        {
            $user->boss_id = MemberHelper::checkLogin()->id;
        }
        else
        {
            $user->boss_id = $request->get('boss_id');
        }
        
        // Get role.
        $role = $user->role;
        
        // Get boss.
        $boss = User::find($user->boss_id);
        
        // Set user from session.
        Session::put('user', $user);
        
        // Prepare data for view.
        $data = array (
            'user' => $user,
            'role' => $role,
            'boss' => $boss
        );
        
        return $data;
    }

    /**
     * Get link to member detail page.
     * 
     * @param string $userId
     * @return string
     */
    private static function _linkToDetail($userId = '')
    {
        return html_entity_decode(trans('ID') . ': <a href="' . url('/member/' . $userId . '/detail') . '">' . $userId . '</a>');
    }

    /**
     * Common function for save user.
     * 
     * @param object $record
     * @param object $user
     * @return object
     */
    private static function _saveUser(&$record, $user)
    {
        if (! $user) {
            return null;
        }
        
        // Build data.
        $record->email        = $user->email;
        $record->name         = $user->name;
        $record->kana         = $user->kana;
        $record->password     = bcrypt($user->password);
        $record->telephone_no = $user->telephone_no;
        $record->birthday     = $user->birthday;
        $record->note         = ($user->note) ? $user->note : '';
        if (MemberHelper::getCurrentUserRole() == 'boss')
        {
            $user->role  = 'employee';
            $record->boss_id = MemberHelper::checkLogin()->id;
        }
        else
        {
            if ($user->role == 'employee') {
                $record->boss_id = (int) $user->boss_id;
            } else {
                $record->boss_id = 0;
            }
        }
        
        // Add role for user.
        if (MemberHelper::getCurrentUserRole() != 'employ')
        {
            $record->role = $user->role;
        }

        $record->save();
        
        return $record;
    }
}
