<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Subscribe;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscribeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:subscriber-list', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.subscriber.index');
    }

    public function getData()
    {
        $subscriber = Subscribe::latest()->get();

        return DataTables::of($subscriber)
        ->addIndexColumn()
            
            ->editColumn('action', function ($subscriber) {
                $return = "<div class=\"btn-group\">";
                if (!empty($subscriber->id))
                {
                    $return .= "
                            <a href=\"/susbcribe/email_send/$subscriber->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-rocket'></i></a>
                                ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action'
            ])
            ->make(true);
    }
}
