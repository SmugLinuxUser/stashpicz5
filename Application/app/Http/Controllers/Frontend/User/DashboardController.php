<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\FileEntry;
use Carbon\Carbon;
use App\Models\View;
class DashboardController extends Controller
{
    public function redirectToDashboard()
    {
        return redirect()->route('user.dashboard');
    }

    public function index()
    {
               
        $countFileEntries = FileEntry::currentUser()->notExpired()->count();
        $countViews = View::currentUser()->count();
        $viewsCount = View::currentUser()->where('date', '>=', Carbon::now()->startOfMonth())
            
            ->selectRaw('DATE(date) as ass, COUNT(*) AS count')
            ->groupBy('ass')
            ->pluck('count');

        $uploadCount = FileEntry::currentUser()->where('created_at', '>=', Carbon::now()->startOfMonth())
        ->notExpired()
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->pluck('count');
        return view('frontend.user.dashboard.index', ['countFileEntries' => $countFileEntries, 'uploadCount' => $uploadCount, 'viewsCount' => $viewsCount, 'countViews' => $countViews]);
    }

    public function viewsChart()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dates = chartDates($startDate, $endDate);
        $monthlyUploads = View::currentUser()->where('date', '>=', Carbon::now()->startOfMonth())
            
            ->selectRaw('DATE(date) as ass, COUNT(*) AS count')
            ->groupBy('ass')
            ->pluck('count', 'ass');
        $monthlyUploadsData = $dates->merge($monthlyUploads);
        $uploadsChartLabels = [];
        $uploadsChartData = [];
        foreach ($monthlyUploadsData as $key => $value) {
            $uploadsChartLabels[] = Carbon::parse($key)->format('d M');
            $uploadsChartData[] = $value;
        }
        $suggestedMax = (max($uploadsChartData) > 9) ? max($uploadsChartData) + 2 : 10;
        return ['uploadsChartLabels' => $uploadsChartLabels, 'uploadsChartData' => $uploadsChartData, 'suggestedMax' => $suggestedMax, 'uploadCount' => $monthlyUploads];
    }

        public function uploadsChart()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dates = chartDates($startDate, $endDate);
        $monthlyUploads = FileEntry::currentUser()->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->notExpired()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $monthlyUploadsData = $dates->merge($monthlyUploads);
        $uploadsChartLabels = [];
        $uploadsChartData = [];
        foreach ($monthlyUploadsData as $key => $value) {
            $uploadsChartLabels[] = Carbon::parse($key)->format('d M');
            $uploadsChartData[] = $value;
        }
        $suggestedMax = (max($uploadsChartData) > 9) ? max($uploadsChartData) + 2 : 10;
        return ['uploadsChartLabels' => $uploadsChartLabels, 'uploadsChartData' => $uploadsChartData, 'suggestedMax' => $suggestedMax, 'viewCount' => $monthlyUploads];
    }




}
