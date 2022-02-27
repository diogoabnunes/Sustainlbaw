<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Event;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class SearchController extends Controller
{

    public function index(Request $request)
    {

        //$posts = BlogPost::all();
        $blog_posts = BlogPost::all();
        $events = Event::all();
        $vendors = Vendor::all();
        return view('pages.searchPage', ['blog_posts' => $blog_posts, 'events' => $events, 'vendors' => $vendors, 'onlySome' => false]);
    }

    public function search(Request $request)
    {

        if (!$request->exists('keywords')) {
            return $this->returnAll();
        }

        /*$showEvents = $request->input('events');
        if ($showEvents) return 3;
        else return 4;
        $showPosts = $request->input('posts');

        if (!$request->exists('events')) {
            return 2;
        }*/


        return $this->getResults($request, false);
    }

    public function searchUsers(Request $request)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            if (!$request->exists('keywords')) {
                $users = User::all();
                return view('pages.administration', ['users' => $users]);
            }
            $query = $request->keywords;
            $people = $this->getUsers($query);

            return view('pages.administration', ['users' => $people]);
        }
        return abort(403);
    }

    public function returnAll()
    {
        $blog_posts = BlogPost::all();
        $events = Event::all();
        $vendors = Vendor::all();

        // $eventBlog = $events->merge($blog_posts);
        // $results = $eventBlog->merge($vendors);
        // return view('pages.searchPage', ['results' => $results, 'onlySome' => false]);

        // return view('pages.searchPage', ['blog_posts' => $blog_posts, 'events' => $events, 'vendors' => $vendors, 'onlySome' => false]);
        return view('pages.searchPage', ['blog_posts' => $blog_posts, 'events' => $events, 'vendors' => $vendors, 'onlySome' => false]);
    }



    public function getResults(Request $request, $isJson)
    {
        $query = $request->keywords;
        if ($query == "") {
            return $this->returnAll();
        }
        $blog_posts = $this->getBlogPosts($query);
        $events = $this->getEvents($query);
        $vendors = $this->getVendors($query);



        // $results = $events->merge($blog_posts);
        // $results = $events->merge($vendors);
        // $results = $results->sortByDesc('rank');
        // return view('pages.searchPage', ['results' => $results, 'onlySome' => true]);
        return view('pages.searchPage', ['blog_posts' => $blog_posts, 'events' => $events, 'vendors' => $vendors, 'onlySome' => true]);
    }


    private function getUsers($query)
    {
        $portuguese = addslashes("portuguese");
        if ($query) { //Search for people whose name contains the keywords
            $people = DB::select(
                'SELECT user_id, first_name, last_name, email, "role", image_path, ts_rank_cd(user_search, plainto_tsquery( :portuguese, :keywords)) AS rank
                FROM "user"
                WHERE user_search @@ plainto_tsquery( :portuguese, :keywords)
                ORDER BY rank DESC
                LIMIT 10',
                [
                    'keywords' => $query,
                    'portuguese' => $portuguese,
                    // 'offset' => $offset,
                    // 'limit' => $limit
                ]
            );
            $people = User::hydrate($people);
        } else $people = collect();
        return $people;
    }

    private function getBlogPosts($query)
    {
        $portuguese = addslashes("portuguese");
        if ($query) { //Search for people whose name contains the keywords
            $blog_posts = DB::select(
                'SELECT blog_post_id, title, content, publication_date, author, editor, image_path, ts_rank_cd(blog_search, plainto_tsquery( :portuguese, :keywords)) AS rank
                FROM "blog_post"
                WHERE blog_search @@ plainto_tsquery(:portuguese, :keywords)
                ORDER BY rank DESC',
                [
                    'keywords' => $query,
                    'portuguese' => $portuguese,
                    // 'offset' => $offset,
                    // 'limit' => $limit
                ]
            );
            $blog_posts = User::hydrate($blog_posts);
        } else $blog_posts = collect();
        return $blog_posts;
    }

    private function getVendors($query)
    {
        $portuguese = addslashes("portuguese");
        if ($query) { //Search for people whose name contains the keywords
            $vendors = DB::select(
                'SELECT vendor_id, name, job, location_id, description, image_path, ts_rank_cd(vendor_search, plainto_tsquery(:portuguese, :keywords)) AS rank
                FROM "vendor"
                WHERE vendor_search @@ plainto_tsquery(:portuguese, :keywords)
                ORDER BY rank DESC',
                [
                    'keywords' => $query,
                    'portuguese' => $portuguese,
                    // 'offset' => $offset,
                    // 'limit' => $limit
                ]
            );
            $vendors = User::hydrate($vendors);
        } else $vendors = collect();
        return $vendors;
    }

    private function getEvents($query)
    {
        $portuguese = addslashes("portuguese");
        if ($query) { //Search for people whose name contains the keywords
            $events = DB::select(
                'SELECT event_id, name,image_path,start_date,end_date,price, location,description, ts_rank_cd(event_search, plainto_tsquery(:portuguese, :keywords)) AS rank
                FROM event
                WHERE event_search @@ plainto_tsquery(:portuguese, :keywords) AND
                start_date >= current_date
                ORDER BY rank DESC',
                [
                    'keywords' => $query,
                    'portuguese' => $portuguese,
                    // 'offset' => $offset,
                    // 'limit' => $limit
                ]
            );
            $events = User::hydrate($events);
        } else $events = collect();
        return $events;
    }
}
