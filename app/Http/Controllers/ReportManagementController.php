<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminte\Support\Facades\Auth;
use App\Services\ReportManagementServices;
use App\Http\Requests\GenerateFileRequest;
use App\Http\Requests\ReportRequest;
use Carbon\Carbon;

class ReportManagementController extends Controller
{
    public function GenerateReport(ReportRequest $request){
        $selectedReport = $request['selectedReport'];
        $dateRangedBased = $request['dateRangedBased'];
        $dateRanged =  [$request['dateRanged']];
        $category = $request['category'];
        $status = $request['status'];
        $genreport = ReportManagementServices::Report($selectedReport, $dateRangedBased, $dateRanged, $category, $status);
        return $genreport;

    }

    public function GenerateSOA(Request $request){
//$id = auth('sanctum')->user();
        // $dateStart = $request->dateStart;
        // $dateEnd = $request->dateEnd;
        $member_id = $request->id;
        $dateStart = Carbon::parse($request->dateStart)->startOfDay();
        $dateEnd = Carbon::parse($request->dateEnd)->endOfDay();
        $gensoa = ReportManagementServices::Generate_SOA($member_id,$dateStart, $dateEnd);
        return $gensoa;
    }
}
