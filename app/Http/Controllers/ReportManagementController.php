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
}
