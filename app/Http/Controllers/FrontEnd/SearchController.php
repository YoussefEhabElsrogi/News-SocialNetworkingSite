<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */ public function __invoke(Request $request)
    {
        // Validate and sanitize the search input
        $searchTerm = $this->validateSearch($request);

        // Retrieve posts based on the search term
        $posts = $this->searchPosts($searchTerm);

        // Handle case where no posts are found
        if ($posts->isEmpty()) {
            setFlashMessage('error', 'No posts found matching your search criteria.');
            return redirect()->route('front.index');
        }

        // Return the search results view
        return view('frontend.search', compact('posts'));
    }

    /**
     * Validate the search input.
     *
     * @param Request $request
     * @return string
     */
    private function validateSearch(Request $request): string
    {
        $validated = $request->validate([
            'search' => 'required|string'
        ]);

        return strip_tags($validated['search']);
    }

    /**
     * Search posts based on the given keyword.
     *
     * @param string $keyWord
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function searchPosts(string $keyWord)
    {
        return Post::active()->where('title', 'LIKE', "%$keyWord%")
            ->orWhere('desc', 'LIKE', "%$keyWord%")
            ->with('images')
            ->select('id', 'title', 'slug', 'desc')
            ->paginate();
    }
}
