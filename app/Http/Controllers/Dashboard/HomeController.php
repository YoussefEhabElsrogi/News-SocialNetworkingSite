<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:home');
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $currentYear = Carbon::now()->year;

        // Chart of posts
        $postsChart = $this->getChartData(\App\Models\Post::class, 'created_at', $currentYear);

        // Chart of users
        $usersChart = $this->getChartData(\App\Models\User::class, 'created_at', $currentYear);

        // Chart of comments
        $commentsChart = $this->getChartData(\App\Models\Comment::class, 'created_at', $currentYear);

        // Chart of contacts
        $contactsChart = $this->getChartData(\App\Models\Contact::class, 'created_at', $currentYear);

        return view('dashboard.index', compact('postsChart', 'usersChart', 'commentsChart', 'contactsChart'));
    }

    /**
     * Get chart data based on model and date field.
     */
    private function getChartData($model, $dateField, $year)
    {
        $table = (new $model)->getTable();

        $postsByMonth = DB::table($table)
            ->selectRaw('MONTH(' . $dateField . ') as month, COUNT(*) as total')
            ->whereYear($dateField, $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartData = ['label' => [], 'data' => array_fill(0, 12, 0)];

        foreach ($postsByMonth as $post) {
            $chartData['label'][] = Carbon::create(null, $post->month, 1)->format('M');
            $chartData['data'][$post->month - 1] = $post->total;
        }

        return $chartData;
    }
}
