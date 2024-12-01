<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;

class GeneralSearchController extends Controller
{
    /**
     * Handle the search request and delegate to the appropriate method.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function search(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'keyword' => 'required|string|max:255',
            'option' => 'required|in:user,post,category,contact',
        ]);

        return match ($validated['option']) {
            'user' => $this->searchUsers($validated['keyword']),
            'post' => $this->searchPosts($validated['keyword']),
            'category' => $this->searchCategories($validated['keyword']),
            'contact' => $this->searchContacts($validated['keyword']),
            default => redirect()->back(),
        };
    }

    /**
     * Search for users.
     *
     * @param string $keyword
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    private function searchUsers(string $keyword)
    {
        $users = User::where('name', 'LIKE', "%{$keyword}%")->paginate(10);
        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Search for posts.
     *
     * @param string $keyword
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    private function searchPosts(string $keyword)
    {
        $posts = Post::where('title', 'LIKE', "%{$keyword}%")->paginate(10);
        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Search for categories.
     *
     * @param string $keyword
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    private function searchCategories(string $keyword)
    {
        $categories = Category::where('name', 'LIKE', "%{$keyword}%")->paginate(10);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Search for contacts.
     *
     * @param string $keyword
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    private function searchContacts(string $keyword)
    {
        $contacts = Contact::where('name', 'LIKE', "%{$keyword}%")->paginate(10);
        return view('dashboard.contacts.index', compact('contacts'));
    }
}
