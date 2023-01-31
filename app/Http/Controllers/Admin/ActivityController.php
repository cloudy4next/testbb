<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{


    public function index()
    {
        if (!ActivityLog::first()) {
            return view('admin.activity-log.empty');
        }

        $logs = $this->indexData();
        $logTypes = $this->getLogTypeData();
        // dd($logTypes);
        return view('admin.activity-log.index', [
            'logs' => $logs,
            'logTypes' => $logTypes
            ]);
    }

    public function search(Request $request)
    {
        if (!ActivityLog::first()) {
            return view('admin.activity-log.empty');
        }

        if ($request->from) {
            if (!$request->to) {
                return back()->with('error', 'You must select both dates');
            }
            if ($request->to < $request->from) {
                    return back()->with('error', 'Second date must be more than first one');
                    }
                    }
        $query = $request->query();
        $logs = $this->searchData($request);
        $logTypes = $this->getLogTypeData();


        if (!$logs) {
            return view('admin.activity-log.empty');
        }
        // dd($logs);

        return view('admin.activity-log.index', [
            'logs' => $logs,
            'logTypes' => $logTypes,
            'query' => $query
            ]);
        }

    public function getUserName(Request $request)
    {
        $searchTerm = $request['user_name'];

        $user = User::query()
            ->select('name')
            ->where('name', 'like', "%{$searchTerm}%")
            ->get();

            return view('admin.activity-log.user_names',[
            'users' => $user
        ]);
    }
    public function indexData()
    {
        return ActivityLog::paginate(25);
    }

    public function getLogTypeData()
    {
        return ActivityLog::select('log_name')
        ->groupBy('log_name')
        ->get();
    }

    public function searchData($request)
    {
        $user_ids = '';

        if (null != $request['user_name']) {
            $user_ids = $this->getUserIds($request->input('user_name'));
        }

        $results = DB::table('activity_log as ac');

        if (null != $request['log_name']) {
            $results = $results->where('ac.log_name', '=', $request['log_name']);
            unset($request['log_name']);
        }

        if (null != $request['from'] && null != $request['to']) {
            $results = $results->whereBetween('ac.created_at', [$request['from'], $request['to']]);
            unset($request['from']);
            unset($request['to']);
        }

        if (null != $user_ids) {
            $results = $results->whereIn('ac.causer_id', $user_ids);
            unset($request['user_name']);
        }

        return $results
        ->paginate(25);
    }

    private function getUserIdsData($user_name)
    {
        return User::query()
        ->select('id')
        ->where('name', 'like', "%{$user_name}%")
        ->get();
     }
}